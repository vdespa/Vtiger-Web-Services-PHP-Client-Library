Vtiger-Web-Services-PHP-Client-Library
======================================

Vtiger Web Services PHP Client Library (vtwsphpclib)

Modern Vtiger Web Services Client

Build Status
---------------------
Travis-CI: [![Build Status](https://travis-ci.org/vdespa/Vtiger-Web-Services-PHP-Client-Library.png)](https://travis-ci.org/vdespa/Vtiger-Web-Services-PHP-Client-Library)

# Installation

The recommended way to install vtwsphpclib is with [Composer](https://getcomposer.org/). Composer is a dependency management tool for PHP.

Specify vtwsphpclib as a dependency in your **composer.json** file:

	{
   		"require": {
      		"vdespa/vtiger": "dev-master"
   		}
	}

# Usage

## Creating the WSClient object
	use Vdespa\Vtiger;

	$url = 'http://example.com/';

	$config = [
		'auth' => [
			'username' => 'YOURVTIGERUSERNAME',
			'accesskey' => 'YOURVTIGERACCESSKEY'
		]
	];

	$wsclient = new Vtiger\WSClient($url, $config);

## Retrieving Errors

If an operation fails, the return value will be false. No error will be displayed unless you call

	echo $wsclient->getLastError();

## Create Object

	$create = $wsclient->createObject('Accounts', array('accountname' => 'Test account'));

## Other operations

-- Work in progress --

# License

Licensed using the MIT license. See LICENSE.

# Thanks
- Build with Guzzle
- Inspired by vtwsclib – vtiger CRM Web Services Client Library version 1.4
