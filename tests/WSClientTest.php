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

use Vdespa\Vtiger\WSClient;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Subscriber\History;
use GuzzleHttp\Stream\Stream;


class WSClientTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @var WSClient
	 */
	protected $wsclient;

	/**
	 * @var History
	 */
	protected $history;

	protected function setUp()
	{
		// Create a history subscriber
		$this->history = new History();

		// Create the client
		$this->client = new Client;

		// Add the history subscriber to the client.
		$this->client->getEmitter()->attach($this->history);

		$this->authentication();
	}

	protected function authentication()
	{
		// Setting for the WSClient
		$url = 'http://www.example.com';
		$config = [
			'auth' => [
				'username' => 'system',
				'accesskey' => 'TkDShdBqAnav2EhG'
			],
			// Providing the Guzzle client in test so we can easily use history and mock responses
			'testing' => [
				'client' => $this->client
			]
		];

		$mock = new Mock([
			// Use response object
			new Response(200, [], Stream::factory(fopen('./tests/mock/body-response-challenge.txt', 'r+'))),
			new Response(200, [], Stream::factory(fopen('./tests/mock/body-response-login.txt', 'r+'))),
		]);
		$this->client->getEmitter()->attach($mock);

		// Create the WSClient
		$this->wsclient = new WSClient($url, $config);

		$requests = $this->history->getRequests();

		// Operation getchallenge
		$this->assertEquals(
			'http://www.example.com/webservice.php?operation=getchallenge&username=system',
			$requests[0]->getUrl()
		);
		$this->assertEquals('GET', $requests[0]->getMethod());

		// Operation login
		$this->assertEquals(
			'http://www.example.com/webservice.php',
			$requests[1]->getUrl()
		);
		$this->assertEquals('POST', $requests[1]->getMethod());
		$this->assertEquals(
			'operation=login&username=system&accessKey=452e4d2f10d60e481c2056ef2e12ed48',
			(string) $requests[1]->getBody()
		);

		// Detaching subscriber
		$this->client->getEmitter()->detach($mock);
	}

	public function testCanCreateClient()
	{
		$this->assertInstanceOf('\GuzzleHttp\Client', $this->client);
	}

	public function testCanCreateWSClient()
	{
		$this->assertInstanceOf('\Vdespa\Vtiger\WSClient', $this->wsclient);
	}

	public function testCanGetAvailableModules()
	{
		// Create a mock subscriber and queue the response.
		$mock = new Mock([
			new Response(file_get_contents('./tests/mock/response-availablemodules.txt'))
		]);
		$this->client->getEmitter()->attach($mock);

		// Get available modules
		$this->wsclient->getAvailableModules();

		// Get the last request
		$lastRequest = $this->history->getLastRequest();

		$this->assertEquals(
			'http://www.example.com/webservice.php?operation=listtypes&sessionName=18653fb863106084',
			$lastRequest->getUrl()
		);
		$this->assertEquals('GET', $lastRequest->getMethod());
		$this->assertEmpty((string) $lastRequest->getBody());

		// Detaching subscriber
		$this->client->getEmitter()->detach($mock);
	}
}