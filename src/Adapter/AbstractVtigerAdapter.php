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

namespace Vdespa\Vtiger\Adapter;

use Vdespa\Vtiger\Exceptions\WebServiceException;

class AbstractVtigerAdapter
{
    /**
     * @param string $vTigerResponse
     *
     * @return mixed
     */
    protected function decodeResponse($vTigerResponse)
    {
        if ((string) $vTigerResponse === '')
        {
            throw new \InvalidArgumentException(
                sprintf('The response is empty. Request URI: ' . $vTigerResponse->getHeader()),
                1445078364
            );
        }

        $response = json_decode($vTigerResponse);

        if ($response instanceof \stdClass === false)
        {
            throw new \InvalidArgumentException(
                sprintf("Failed to parse JSON string '%s'. Error: '%s'", $vTigerResponse, json_last_error_msg()),
                1445076405
            );
        }

        if (property_exists($response, 'success') === false)
        {
            throw new \DomainException(
                'Could not find property "success" in the response object',
                1445076599
            );
        }

        if ($response->success !== true)
        {
            $this->handleErrorResponse($response);
        }

        if (property_exists($response, 'result') === false)
        {
            throw new \DomainException(
                'Could not find property "result" in the response object',
                1445076601
            );
        }

        return $response->result;
    }

    /**
     * @param \stdClass $response
     */
    private function handleErrorResponse(\stdClass $response)
    {
        throw new WebServiceException(
            sprintf(
                'The webservice responded with an error: %s. Error code: %s.',
                $response->error->message,
                $response->error->code
            ),
            1445076600
        );
    }
}