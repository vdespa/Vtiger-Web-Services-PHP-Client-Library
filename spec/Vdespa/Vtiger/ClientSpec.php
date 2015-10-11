<?php

namespace spec\Vdespa\Vtiger;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;


class ClientSpec extends ObjectBehavior
{
    private $validConfiguration = [
        'credentials' => [
            'username' => 'admin',
            'accessKey'=> 'key'
        ],
        'base_url' => 'http://www.example.com/api/'
    ];

    function let(GuzzleHttp\Client $httpClient)
    {
        $this->beConstructedWith(
            $httpClient,
            $this->validConfiguration
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Vdespa\Vtiger\Client');
    }

    function it_should_not_initialize_without_credentials($httpClient)
    {
        $this->beConstructedWith($httpClient, []);
        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    function it_should_authenticate_on_initialization()
    {
        $this->isAuthenticated()->shouldReturn(true);
    }

    function it_should_get_available_modules()
    {
        $this->beConstructedWith(
            $this->getHttpClientMockForAuthentication(),
            $this->validConfiguration
        );

        $this->getAvailableModules()->shouldReturn([]);
    }

    private function getHttpClientMockForAuthentication()
    {
        $mock = new MockHandler([
            // Use response object
            //new Response(200, [], Stream::factory(fopen(dirname(__FILE__) . '/ResponseMocks/body-response-challenge.txt', 'r+'))),
            //new Response(200, [], Stream::factory(fopen(dirname(__FILE__) . '/ResponseMocks/body-response-login.txt', 'r+'))),
        ]);
        $handler = HandlerStack::create($mock);
        return new GuzzleHttp\Client(['handler' => $handler]);
    }

}
