Vtiger Web Services PHP Client Library (vtwsphpclib) - ALPHA DEVELOPMENT
======================================
Composer based Vtiger Web Services Client.

Build Status
---------------------
Travis-CI: [![Build Status](https://travis-ci.org/vdespa/Vtiger-Web-Services-PHP-Client-Library.svg?branch=development)](https://travis-ci.org/vdespa/Vtiger-Web-Services-PHP-Client-Library)

# About

Version 1.0 comes with a completely new approach using Domain Driven Design (DDD) patterns on how to use the Vtiger API.
It provides domain models (such as Account) and uses repositories for interacting with the domain classes.
Also the error handling mechanism as been redesigned and will give you the user the possibility of doing Exception Handling.

A legacy mode (more similar with the initial 0.1 version is planned, but not available yet).

# Installation

The recommended way to install vtwsphpclib is with [Composer](https://getcomposer.org/). Composer is a dependency management tool for PHP.

Specify vtwsphpclib as a dependency in your **composer.json** file:

	{
   		"require": {
      		"vdespa/vtiger": "1.0.0-alpha"
   		}
	}

In case you are new to Composer, you need to include the file `/vendor/autoload.php` somewhere in your project.

# How to use

## Creating the Client object

You need to create an instance of the Client object in order to connect to the Vtiger API. 
Therefore you need the server URL and a valid username and the access key for the user.  

```php
	use Vdespa\Vtiger\Client;
	
	$config = $validConfiguration = [
		'credentials' => [
			'username' => 'YOUR_VTIGER_USERNAME',
			'accessKey'=> 'YOUR_VTIGER_ACCESSKEY'
		],
		'httpClient' => [
			'base_url' => 'http://example.com/webservice.php'
		]
	];
	
	$wsClient = new Client($config);
```

## Error handling

If something does wrong, the Client will throw Exceptions which you will need to handle. 
If you don't have a global exception handling that will catch any exception that was thrown, you need to put all Client
calls between try - catch blocks.

	try {
		$wsClient = new Client($config);
	} catch (Exception $e)
	{
		// Implement your own exception handling here.
		// Bad example of error handling: die($e->getMessage());
	}

[//]: <> (TODO: Document all types of Exceptions that the Client can throw)

## Using the Repositories

Each time you need to working with Entities, you first need to get an instance of the repository which contains the
entity you want to work with. 

For example, if you want to create a new Account and persist it, you will need the AccountsRepository.

    /** @var AccountsRepository $accountsRepository */
    $accountsRepository = $wsClient->getRepositoryByName('Accounts');
    
Each Entity Repository exposes a couple of CRUD methods as defined by the EntityRepositoryInterface.

    - create
    - retrieveById
    - retrieveAll
    - update
    - deleteById
    
In order to perform CRUD operations, you need to work with a repository.

## Creating a new Entity

Say you want to create a new Entity of type Account. 

    use \Vdespa\Vtiger\Domain\Model\Account;
    
    // Create a new Account
    $account = new Account('My Account Name');
    
    // Get an instance of the Accounts Repository
    /** @var AccountsRepository $accountsRepository */
    $accountsRepository = $wsClient->getRepositoryByName('Accounts');
    
    // Save the account
    $accountsRepository->create($account);
    
## Retrieving an Entity

You can retrieve an entity if you know the id.
    
    $account = $accountsRepository->getById('11x5');
    
## Retrieving all Entities of a kind

If you want to retrieve all Accounts:

    $accounts = $accountsRepository->retrieveAll();

Notice: This will actually retrieve all accounts (there is no predefined limit, so use with caution).

## Updating an Entity

To update an existing entity you first need an object with is already persisted (has the id set). The easiest is to
first retrieve the Entity and to apply changes to it.

    // Retrieve Account
    $accountToBeUpdated = $accountsRepository->getById('11x5');

    // Change the name
    $accountToBeUpdated->setName('Updated Account Name');

    // Persist the changes
    $accountsRepository->update($accountToBeUpdated);

## Deleting an Entity

To delete an existing entity you just need the id of the Entity you want to delete. 

Say you want to delete an Account:

    $accountsRepository->deleteById('11x5'));

# License

Licensed using the MIT license. See LICENSE.

# Contributing

Please report any bugs that you encounter. If you have a solution as well, please submit a Pull Request.

# Thanks
- Build with Guzzle 6.*
- Inspired by vtwsclib – vtiger CRM Web Services Client Library version 1.4