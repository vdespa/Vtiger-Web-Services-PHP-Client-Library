<?php
// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

use Vdespa\Vtiger;

class WSClientTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		$this->client = new HttpClient();

		$url = 'http://vtigercrm6x/';

		$config = [
			'auth' => [
				'username' => 'system',
				'accesskey' => 'TkDShdBqAnav2EhG'
			]
		];

		$this->wsclient = new Vtiger\WSClient($url, $config);
	}

	public function testCanCreateClient()
	{
		$this->assertInstanceOf('\Vdespa\Vtiger\WSClient', $this->wsclient);
	}
}