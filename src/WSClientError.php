<?php
/**
 * Vtiger Web Services PHP Client Library (vtwsphpclib)
 *
 *
 * Inspired by vtwsclib – vtiger CRM Web Services Client Library version 1.4
 * Build with Guzzle. Thanks!
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2014, Valentin Despa <info@vdespa.de>. All rights reserved.
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
 * @copyright 2014 Valentin Despa <info@vdespa.de>
 * @license   The MIT License (MIT)
 */

namespace Vdespa\Vtiger;

/**
 * Class WSClientError
 *
 * @package Vdespa\Vtiger
 */
class WSClientError
{
	protected $errorCode;

	/**
	 * @return mixed
	 */
	public function getErrorCode()
	{
		return $this->errorCode;
	}

	/**
	 * @return mixed
	 */
	public function getMessage()
	{
		return $this->message;
	}
	protected $message;
	protected $xdebugMessage;

	/**
	 * Constructor
	 *
	 * @param $code
	 * @param $message
	 * @param $xdebugMessage
	 */
	public function __construct($code, $message, $xdebugMessage)
	{
		$this->errorCode = $code;
		$this->message = $message;
		$this->xdebugMessage = $xdebugMessage;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return 'Error code: ' . $this->errorCode . '. Message: ' . $this->message;
	}

	/**
	 * @return mixed
	 */
	public function getDebugMessage()
	{
		return $this->xdebugMessage;
	}
} 