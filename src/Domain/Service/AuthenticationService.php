<?php


namespace Vdespa\Vtiger\Domain\Service;


use Vdespa\Vtiger\Domain\PayloadFactory;
use Vdespa\Vtiger\Session\SessionManager;
use Vdespa\Vtiger\Domain\Model\Challenge;
use Vdespa\Vtiger\Adapter\AdapterStrategyFactory;

class AuthenticationService
{
    private $config;
    private $payloadFactory;

    private $requestService;
    private $sessionManager;

    public function __construct(array $config, PayloadFactory $payloadFactory, RequestService $requestService, SessionManager $sessionManager)
    {
        $this->config = $config;
        $this->payloadFactory = $payloadFactory;
        $this->requestService = $requestService;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @return void
     */
    public function authenticate()
    {
        $username = $this->config['credentials']['username'];
        $accessKey = $this->config['credentials']['accessKey'];

        $challenge = $this->getChallenge($username);

        $payload = $this->payloadFactory->createLoginPayload($username, $challenge, $accessKey);

        $response = $this->requestService->sendRequest($payload);
        $adapterStrategyFactory = new AdapterStrategyFactory(); // FIXME - This is a constructor dependency
        $adapter = $adapterStrategyFactory->buildFromPayload($payload);
        $session = $adapter->transformFromVtiger($response->getBody());

        $this->sessionManager->setSession($session);
    }

    public function logout()
    {
        $payload = $this->payloadFactory->createLogoutPayload();
        $response = $this->requestService->sendRequest($payload);
        $adapterStrategyFactory = new AdapterStrategyFactory(); // FIXME - This is a constructor dependency
        $adapter = $adapterStrategyFactory->buildFromPayload($payload);
        return $adapter->transformFromVtiger($response->getBody());
    }

    public function extendSession()
    {
        $payload = $this->payloadFactory->createExtendSessionPayload($this->config['credentials']['username']);
        $response = $this->requestService->sendRequest($payload);
        $adapterStrategyFactory = new AdapterStrategyFactory(); // FIXME - This is a constructor dependency
        $adapter = $adapterStrategyFactory->buildFromPayload($payload);
        return $adapter->transformFromVtiger($response->getBody());
    }

    /**
     * Get a challenge token from the server
     *
     * @param string $username
     *
     * @return Challenge
     */
    private function getChallenge($username)
    {
        $payload = $this->payloadFactory->createChallengePayload($username);
        $response = $this->requestService->sendRequest($payload);


        $adapterStrategyFactory = new AdapterStrategyFactory();
        $adapter = $adapterStrategyFactory->buildFromPayload($payload);
        return $adapter->transformFromVtiger($response->getBody());
    }
}