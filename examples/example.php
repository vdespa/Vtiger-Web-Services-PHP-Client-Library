<?php
require_once '../vendor/autoload.php';

use Vdespa\Vtiger\Domain\Repository\ModulesEntityRepository;
use Vdespa\Vtiger\Domain\Repository\AccountsRepository;

$config = $validConfiguration = [
    'credentials' => [
        'username' => 'admin',
        'accessKey'=> 'GAoZtO4AqMYuiRCs'
    ],
    'httpClient' => [
        'base_url' => 'http://vtiger.local/webservice.php'
    ]


];
$wsClient = new Vdespa\Vtiger\Client($config);
//$accountsRepository = $wsClient->getRepositoryByName('AccountsEntityRepository');

/** @var ModulesEntityRepository $modulesRepository */
//$modulesRepository = $wsClient->getRepositoryByName('Modules');
//$module = $modulesRepository->getByName('Accounts');

/** @var AccountsRepository $accountsRepository */
$accountsRepository = $wsClient->getRepositoryByName('Accounts');
/*
for ($i = 1; $i < 250; $i++)
{
    $account = new \Vdespa\Vtiger\Domain\Model\Account('Account' . uniqid());

    $accountsRepository->create($account);
}
*/

$accountsRepository->retrieveAll();

//$account5 = $accountsRepository->getById('11x5');

//$module = $modulesRepository->getByName('Contacts');
// $modulesRepository->listModules();

//$account5->setName('Updated Business Name');
//$accountsRepository->update($account5);

$accountsRepository->deleteById($account2->getId());

$x = 1;

//$accountsRepository->getBy();

//$accountsRepository->getById();

//$wsClient->extendSession();

//$wsClient->logout();



$x = 1;

