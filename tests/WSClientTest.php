<?php
// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

use Vdespa\Vtiger;

echo Vtiger\WSClient::sayHelloWorld();