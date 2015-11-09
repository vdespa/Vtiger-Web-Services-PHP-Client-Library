<?php
/**
 * Vtiger Web Services PHP Client Library (vtwsphpclib)
 *
 * Inspired by vtwsclib – vtiger CRM Web Services Client Library version 1.4
 * Build with Guzzle. Thanks!
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2015, Valentin Despa <info@vdespa.de>. All rights reserved.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    Valentin Despa <info@vdespa.de>
 * @copyright 2015 Valentin Despa <info@vdespa.de>
 * @license   The MIT License (MIT)
 */

namespace Vdespa\Vtiger\Domain\Repository;

use Vdespa\Vtiger\Adapter\AdapterStrategyFactory;
use Vdespa\Vtiger\Domain\PayloadFactory;
use Vdespa\Vtiger\Domain\Service\RequestService;
use Vdespa\Vtiger\Session\SessionManager;
use Vdespa\Vtiger\Domain\Model\EntityInterface;

abstract class AbstractEntityRepository implements EntityRepositoryInterface
{
    /**
     * @var PayloadFactory
     */
    protected $payloadFactory;

    /**
     * @var RequestService
     */
    protected $requestService;

    /**
     * @var AdapterStrategyFactory
     */
    protected $adapterStrategyFactory;

    /**
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * @var string
     */
    protected $type = 'abstract';

    /**
     * @param PayloadFactory $payloadFactory
     * @param RequestService $requestService
     * @param AdapterStrategyFactory $adapterStrategyFactory
     * @param SessionManager $sessionManager
     */
    public function __construct(
        PayloadFactory $payloadFactory,
        RequestService $requestService,
        AdapterStrategyFactory $adapterStrategyFactory,
        SessionManager $sessionManager
    )
    {
        $this->payloadFactory = $payloadFactory;
        $this->requestService = $requestService;
        $this->adapterStrategyFactory = $adapterStrategyFactory;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     */
    public function create(EntityInterface $entity)
    {
        // If the account does not have an assigned user, use the current logged in user.
        if ($entity->getAssignedUserId() === null)
        {
            $entity->setAssignedUserId($this->sessionManager->getSession()->getUserId());
        }

        $adapter = $this->adapterStrategyFactory->buildFromRepositoryType($this->type);
        $data = $adapter->transformToVtiger($entity);

        $payload = $this->payloadFactory->createCreatePayload($this->type, $data);
        $response = $this->requestService->sendRequest($payload);

        $savedAccount = $adapter->transformFromVtiger((string) $response->getBody());

        return $savedAccount;
    }

    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     * @throws \Exception
     */
    public function update(EntityInterface $entity)
    {
        $adapter = $this->adapterStrategyFactory->buildFromRepositoryType($this->type);
        $data = $adapter->transformToVtiger($entity);

        $payload = $this->payloadFactory->createUpdatePayload($data);
        $response = $this->requestService->sendRequest($payload);

        $updatedEntity = $adapter->transformFromVtiger((string) $response->getBody());

        return $updatedEntity;
    }

    /**
     * @param $id
     * @return EntityInterface
     * @throws \Exception
     */
    public function retrieveById($id)
    {
        $payload = $this->payloadFactory->createRetrievePayload($id);
        $response = $this->requestService->sendRequest($payload);
        $adapter = $this->adapterStrategyFactory->buildFromRepositoryType($this->type);
        return $adapter->transformFromVtiger($response->getBody());
    }

    /**
     * @return \ArrayIterator
     * @throws \Exception
     */
    public function retrieveAll()
    {
        $existingCollection = new \ArrayIterator();
        $offset = 0;
        $limit = 100;

        do {
            $query = $query = sprintf('SELECT * FROM %s LIMIT %d, %d;', $this->type, $offset, $limit);
            $payload = $this->payloadFactory->createQueryPayload($query);

            $response = $this->requestService->sendRequest($payload);

            $adapter = $this->adapterStrategyFactory->buildFromRepositoryType($this->type);
            $entities = $adapter->transformFromVtiger((string) $response->getBody());

            $existingCollection = $this->mergeCollection($existingCollection, $entities);

            $offset += 100;
        }
        while ($entities->count() > 0);

        return $existingCollection;
    }

    /**
     * @param \ArrayIterator $existingCollection
     * @param \ArrayIterator $newCollection
     * @return \ArrayIterator
     */
    private function mergeCollection(\ArrayIterator $existingCollection, \ArrayIterator $newCollection)
    {
        foreach ($newCollection as $entity)
        {
            $existingCollection->append($entity);
        }
        return $existingCollection;
    }

    /**
     * @param $id
     * @return boolean
     * @throws \Exception
     */
    public function deleteById($id)
    {
        $payload = $this->payloadFactory->createDeletePayload($id);
        $response = $this->requestService->sendRequest($payload);
        $adapter = $this->adapterStrategyFactory->buildFromPayload($payload);
        return $adapter->transformFromVtiger($response->getBody());
    }

    public function retrieveByModifiedTime(\DateTime $modifiedTime)
    {
        throw new \RuntimeException('Not implemented yet.');
    }

    public function getBy(array $conditions = [])
    {
        throw new \RuntimeException('Not implemented yet.');
    }
}