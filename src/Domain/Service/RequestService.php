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

namespace Vdespa\Vtiger\Domain\Service;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Vdespa\Vtiger\Adapter\AdapterInterface;
use Vdespa\Vtiger\Domain\Model\Session;
use Vdespa\Vtiger\Domain\Payload;
use Vdespa\Vtiger\Adapter\AdapterStrategyFactory;
use GuzzleHttp\Exception\RequestException;
use Vdespa\Vtiger\Session\SessionManager;

class RequestService
{

    private $httpClient;

    private $adapterStrategyFactory;

    private $vtigerWebServiceURL;

    private $sessionManager;

    /**
     * RequestService constructor.
     */
    public function __construct(ClientInterface $httpClient, SessionManager $sessionManager, AdapterStrategyFactory $adapterStrategyFactory)
    {
        $this->httpClient = $httpClient;

        $this->vtigerWebServiceURL = $httpClient->getConfig()['base_url'];

        $this->sessionManager = $sessionManager;

        $this->adapterStrategyFactory = $adapterStrategyFactory;
    }

    /**
     * @param Payload $payload
     *
     * @return Response
     */
    public function sendRequest(Payload $payload) {

        try {
            $request = $this->buildRequest($payload);
            $response = $this->httpClient->send($request);

            $this->checkResponse($request, $response);
            return $response;

        } catch (RequestException $e) {
            throw new \RuntimeException($e->getMessage() . 'URI: ' . $e->getRequest()->getUri());
        }


    }

    private function buildRequest(Payload $payload)
    {
        if ($this->sessionManager->sessionExists() === true)
        {
            $payload = $this->injectSessionId($payload);
        }

        switch ($payload->getMethod()) {
            case 'GET':
                $request = new Request(
                        'GET',
                        $this->vtigerWebServiceURL . '?' . http_build_query($payload->getPayload())
                );
                break;
            case 'POST':
                $request = new Request(
                        'POST',
                        $this->vtigerWebServiceURL,
                        [
                            'Content-Type' => 'application/x-www-form-urlencoded'
                        ],
                        http_build_query($payload->getPayload()));
                break;
            default:
                throw new \InvalidArgumentException(sprintf('The HTTP method "%s" is not implemented.', $payload->getMethod()));
        }

        return $request;
    }

    /**
     * @param Payload $payload
     * @return Payload
     */
    private function injectSessionId(Payload $payload)
    {
        $payloadBody = array_merge(
            $payload->getPayload(),
            [
                'sessionName' => $this->sessionManager->getSession()->getId()
            ]
        );

        return new Payload($payload->type, $payloadBody, $payload->getMethod());
    }

    private function checkResponse(Request $request, Response $response)
    {
        if ((string) $response->getBody() === '')
        {
            throw new \RuntimeException('The response body was empty after requesting URI: ' . $request->getUri() . ' with ' . $request->getBody());

        }
    }
}