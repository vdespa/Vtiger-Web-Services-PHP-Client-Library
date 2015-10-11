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

use GuzzleHttp\ClientInterface;

class Client
{
    private $httpClient;

    private $isAuthenticated = false;

    public function __construct(ClientInterface $httpClient, array $config = [])
    {
        $this->httpClient = $httpClient;

        if (array_key_exists('credentials', $config) === false)
        {
            throw new \InvalidArgumentException('Could not find credentials in the configuration');
        }

        $this->validateCredentials($config['credentials']);

        $this->authenticate();
    }

    /**
     * @param array $credentials
     * @return bool
     * @internal param array $config
     */
    private function validateCredentials(array $credentials)
    {
        if (array_key_exists('username', $credentials) === false && (string) $credentials['username'] !== '')
        {
            throw new \InvalidArgumentException('Could not find the username in the configuration');
        }

        return true;
    }

    /**
     * @return bool
     */
    private function authenticate()
    {
        $this->isAuthenticated = true;
        return true;
    }

    /**
     * @return boolean
     */
    public function isAuthenticated()
    {
        return $this->isAuthenticated;
    }

    /**
     * Get a challenge token from the server
     *
     * @param string $username
     * @return string
     */
    private function getChallenge($username)
    {
        return '';
    }

    /**
     * Provides a list of available modules.
     *
     * This list only contains modules the logged in user has access to.
     *
     * @return array
     */
    public function getAvailableModules()
    {
        return [];
    }
}