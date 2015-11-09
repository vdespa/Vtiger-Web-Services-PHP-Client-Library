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

namespace Vdespa\Vtiger;

use GuzzleHttp;
use Vdespa\Vtiger\Domain\Adapter;
use Vdespa\Vtiger\Domain\PayloadFactory;
use Vdespa\Vtiger\Domain\Repository\EntityRepositoryInterface;
use Vdespa\Vtiger\Domain\Service\AuthenticationService;
use Vdespa\Vtiger\Domain\Service\RequestService;
use Vdespa\Vtiger\Session\SessionManager;

class Client
{
    /**
     * @var PayloadFactory
     */
    private $payloadFactory;

    /**
     * @var RequestService
     */
    private $requestService;

    /**
     * @var SessionManager
     */
    private $sessionManager;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @param array $config
     * @param RequestService|null $requestService
     * @param PayloadFactory|null $payloadFactory
     * @param SessionManager|null $sessionManager
     * @param AuthenticationService|null $authenticationService
     */
    public function __construct(
        array $config = [],
        RequestService $requestService = null,
        PayloadFactory $payloadFactory = null,
        SessionManager $sessionManager = null,
        AuthenticationService $authenticationService = null
    ) {
        // Validate the configuration
        $this->validateConfiguration($config);

        // Create the dependencies if not already provided
        $httpClient = new GuzzleHttp\Client($config['httpClient']);
        $this->sessionManager = $sessionManager ? $sessionManager : $this->sessionManager = new SessionManager();
        $this->requestService = $requestService ? $requestService :
            new RequestService(
                $httpClient,
                $this->sessionManager,
                new \Vdespa\Vtiger\Adapter\AdapterStrategyFactory()
            );
        $this->payloadFactory = $payloadFactory ? $payloadFactory : $this->payloadFactory = new PayloadFactory();


        $this->authenticationService = $authenticationService ? $authenticationService :
            $authenticationService = new AuthenticationService(
                $config,
                $this->payloadFactory,
                $this->requestService,
                $this->sessionManager
            );

        // Authenticate
        $this->authenticationService->authenticate();
    }

    /**
     * Instantiate the requested repository
     *
     * @param $repositoryName
     * @return EntityRepositoryInterface
     */
    public function getRepositoryByName($repositoryName)
    {
        $repositoryName = 'Vdespa\\Vtiger\\Domain\\Repository\\' . ucfirst(strtolower($repositoryName)) . 'Repository';

        return new $repositoryName($this->payloadFactory, $this->requestService, new \Vdespa\Vtiger\Adapter\AdapterStrategyFactory(),
            $this->sessionManager);
    }

    /**
     * Close the current session.
     *
     * @return boolean
     */
    public function logout()
    {
        $this->authenticationService->logout();
    }

    /**
     * Extends the current session
     *
     * @internal For the moment there is a bug and calling this method will throw an exception.
     */
    public function extendSession()
    {
        $this->authenticationService->extendSession();
    }

    /**
     * @return SessionManager
     * @deprecated
     */
    public function getSessionManager()
    {
        return $this->sessionManager;
    }

    /**
     * Validate the user given configuration
     *
     * @param array $config
     */
    private function validateConfiguration(array $config)
    {
        if (array_key_exists('credentials', $config) === false) {
            throw new \InvalidArgumentException('Could not find the key "credentials" in the configuration',
                1445160480);
        }

        if (array_key_exists('httpClient', $config) === false) {
            throw new \InvalidArgumentException('Could not find the key "httpClient" in the configuration', 1445160490);
        }

        $this->validateCredentials($config['credentials']);
    }

    /**
     * @param array $credentials
     * @return bool
     * @internal param array $config
     */
    private function validateCredentials(array $credentials)
    {
        if (array_key_exists('username', $credentials) === false && (string)$credentials['username'] !== '') {
            throw new \InvalidArgumentException('Could not find the username in the credentials configuration');
        }

        return true;
    }
}