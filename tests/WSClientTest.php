<?php
// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

use Vdespa\Vtiger\WSClient;

class WSClientTest extends PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		$url = 'http://vtigercrm6x/';

		$config = [
			'auth' => [
				'username' => 'system',
				'accesskey' => 'TkDShdBqAnav2EhG'
			]
		];

		$this->wsclient = new WSClient($url, $config);
	}

	public function testCanCreateClient()
	{
		$this->assertInstanceOf('\Vdespa\Vtiger\WSClient', $this->wsclient);
	}
}