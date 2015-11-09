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

namespace Vdespa\Vtiger\Domain;

use Vdespa\Vtiger\Domain\Model\Challenge;

class PayloadFactory
{
    /**
     * @param string $username
     * @param Challenge $challenge
     * @param string $accessKey
     * @return Payload
     */
    public function createLoginPayload($username, Challenge $challenge, $accessKey)
    {
        return new Payload(
            'login',
            [
                'operation' => 'login',
                'username' => $username,
                'accessKey' => md5($challenge->getToken() . $accessKey)
            ],
            'POST'
        );
    }

    /**
     * @return Payload
     */
    public function createLogoutPayload()
    {
        return new Payload(
            'logout',
            [
                'operation' => 'logout'
            ],
            'POST'
        );
    }

    /**
     * @param string $username
     * @return Payload
     */
    public function createExtendSessionPayload($username)
    {
        return new Payload(
            'extendsession',
            [
                'operation' => 'extendsession',
                'username' => (string) $username
            ],
            'POST'
        );
    }

    /**
     * @param string $username
     * @return Payload
     */
    public function createChallengePayload($username)
    {
        return new Payload(
            'challenge',
            [
                'operation' => 'getchallenge',
                'username' => (string) $username
            ],
            'GET'
        );
    }

    /**
     * @param string $recordId
     * @return Payload
     */
    public function createRetrievePayload($recordId)
    {
        return new Payload(
            'retrieve',
            [
                'operation' => 'retrieve',
                'id' => $recordId
            ],
            'GET'
        );
    }

    /**
     * @param string $elementType
     * @return Payload
     */
    public function createDescribePayload($elementType)
    {
        return new Payload(
                'describe',
                [
                        'operation' => 'describe',
                        'elementType' => (string) $elementType
                ],
                'GET'
        );
    }

    /**
     * @return Payload
     */
    public function createListTypesPayload()
    {
        return new Payload(
            'listtypes',
            [
                'operation' => 'listtypes'
            ],
            'GET'
        );
    }

    /**
     * @param string $elementType
     * @param string $element
     * @return Payload
     */
    public function createCreatePayload($elementType, $element)
    {
        return new Payload(
            'create',
            [
                'operation' => 'create',
                'elementType' => (string) $elementType,
                'element' => (string) $element
            ],
            'POST'
        );
    }

    /**
     * @param $element
     * @return Payload
     */
    public function createUpdatePayload($element)
    {
        return new Payload(
            'update',
            [
                'operation' => 'update',
                'element' => $element
            ],
            'POST'
        );
    }

    public function createDeletePayload($id)
    {
        return new Payload(
            'delete',
            [
                'operation' => 'delete',
                'id' => $id
            ],
            'POST'
        );
    }

    public function createQueryPayload($query)
    {
        return new Payload(
            'query',
            [
                'operation' => 'query',
                'query' => $query
            ],
            'GET'
        );
    }

}