<?php

namespace spec\Vdespa\Vtiger;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Vdespa\Vtiger\Domain\Model\Challenge;
use Vdespa\Vtiger\Domain\Model\Session;
use Vdespa\Vtiger\Domain\Payload;
use Vdespa\Vtiger\Domain\Service\RequestService;
use Vdespa\Vtiger\Domain\PayloadFactory;
use Vdespa\Vtiger\Session\SessionManager;
use Vdespa\Vtiger\Domain\Service\AuthenticationService;


class ClientSpec extends ObjectBehavior
{
    private $validConfiguration = [
        'credentials' => [
            'username' => 'admin',
            'accessKey'=> 'GAoZtO4AqMYuiRCs'
        ],
        'httpClient' => [
            'base_url' => 'http://vtiger.local/webservice.php'
        ]


    ];


    function let(RequestService $requestService, PayloadFactory $payloadFactory, SessionManager $sessionManager, AuthenticationService $authenticationService)
    {
        $this->beConstructedWith(
            $this->validConfiguration
            //$requestService,
            //$payloadFactory,
            //$sessionManager,
            //$authenticationService
        );
    }

    function it_is_initializable()
    {
        //$this->shouldHaveType('Vdespa\Vtiger\Client');
        $this->getRepositoryByName('Accounts')->shouldReturnAnInstanceOf('Vdespa\Vtiger\Domain\Repository\AccountsRepository');
    }

    function xit_should_not_initialize_without_credentials($requestService)
    {
        $this->beConstructedWith([], $requestService, new PayloadFactory());
        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    function xit_should_get_the_accounts_repository()
    {
        $this->getRepositoryByName('Accounts')->shouldReturnAnInstanceOf('Vdespa\Vtiger\Domain\Repository\AccountsRepository');
    }

    function xit_should_get_the_modules_repository()
    {
        $this->getRepositoryByName('Modules')->shouldReturnAnInstanceOf('Vdespa\Vtiger\Domain\Repository\ModulesRepository');
    }


    /**
     * TODO Move
     */

    private function getHttpClientMockForAuthentication()
    {
        $mock = new MockHandler([
            // Use response object
            new Response(200, [], file_get_contents(dirname(__FILE__) . '/ResponseMocks/body-response-challenge.txt')),
            //new Response(200, [], Stream::factory(fopen(dirname(__FILE__) . '/ResponseMocks/body-response-login.txt', 'r+'))),
        ]);
        $handler = HandlerStack::create($mock);
        return new GuzzleHttp\Client(['handler' => $handler]);
    }

    private function getHttpClientMockForChallange()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(dirname(__FILE__) . '/ResponseMocks/body-response-challenge.txt')),
        ]);
        $handler = HandlerStack::create($mock);
        return new GuzzleHttp\Client(['handler' => $handler]);
    }

}
