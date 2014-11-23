Vtiger Web Services PHP Client Library (vtwsphpclib)
======================================
Composer based Vtiger Web Services Client.

Build Status
---------------------
Travis-CI: [![Build Status](https://travis-ci.org/vdespa/Vtiger-Web-Services-PHP-Client-Library.svg?branch=master)](https://travis-ci.org/vdespa/Vtiger-Web-Services-PHP-Client-Library)

# Installation

The recommended way to install vtwsphpclib is with [Composer](https://getcomposer.org/). Composer is a dependency management tool for PHP.

Specify vtwsphpclib as a dependency in your **composer.json** file:

	{
   		"require": {
      		"vdespa/vtiger": "0.1"
   		}
	}

In case you are new to Composer, you need to include the file `/vendor/autoload.php` file.

# Usage

## Creating the WSClient object
	use Vdespa\Vtiger\WSClient;

	$url = 'http://example.com/';

	$config = [
		'auth' => [
			'username' => 'YOURVTIGERUSERNAME',
			'accesskey' => 'YOURVTIGERACCESSKEY'
		]
	];

	$wsclient = new WSClient($url, $config);

## Retrieving Errors

If an operation fails, the return value will be false. No error will be displayed unless you call

	echo $wsclient->getLastError();

## Create Object

	$create = $wsclient->createObject('Accounts', array('accountname' => 'Test account'));

## List Types

Get a list of Vtiger objects that are available when using the API.

	$availableModules = $wsclient->getAvailableModules();

## Other operations

-- Work in progress --

# License

Licensed using the MIT license. See LICENSE.

# Thanks
- Build with Guzzle 4.*
- Inspired by vtwsclib – vtiger CRM Web Services Client Library version 1.4
