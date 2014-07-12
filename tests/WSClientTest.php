<?php
// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

use Vdespa\Vtiger;

$url = 'http://vtigercrm6x/';

$config = [
	'auth' => [
		'username' => 'system',
		'accesskey' => 'TkDShdBqAnav2EhG'
	]
];

$wsclient = new Vtiger\WSClient($url, $config);

// $listTypes = $wsclient->getAvailableModules();

// print_r($listTypes);

// $moduleDescription = $wsclient->getModuleDescription($listTypes[10]);

// print_r($moduleDescription);

// $create = $wsclient->createObject('Accounts', array('accountname' => 'Test account'));

// $retrieve = $wsclient->retrieveObject('11x31');

// print_r($retrieve);

//$update = $wsclient->updateObject(array('id' => '11x31', 'accountname' => 'Test account 2', 'email1' => 'test@example.com'));
// print_r($update);


// $delete = $wsclient->deleteObject('11x35');

//$query = $wsclient->query('select * from Accounts;');
//print_r($query);

//$sync = $wsclient->sync('Accounts', 0);
//print_r($sync);


//$logout = $wsclient->logout();
//var_dump($logout);

$params = array(
	"syncType" == "application",
	"modifiedTime" => "1402321800",
	"elementType" => "Products"
);
$sync2 = $wsclient->callOperation('sync', $params, "GET");
print_r($sync2);

echo $wsclient->getLastError();