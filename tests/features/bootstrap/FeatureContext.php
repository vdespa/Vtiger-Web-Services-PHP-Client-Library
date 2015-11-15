<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use \Vdespa\Vtiger\Client;
use Vdespa\Vtiger\Domain\Repository\EntityRepositoryInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $clientConfiguration;

    /**
     * @var Exception
     */
    private $lastException;

    /**
     * @var String
     */
    private $currentRepositoryName;

    /**
     * @var EntityRepositoryInterface
     */
    private $currentRepository;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given that I am authenticated
     */
    public function thatIAmAuthenticated()
    {
        $this->clientConfiguration = $this->createClientConfiguration();
        $this->client = new Client($this->clientConfiguration);
    }


    /**
     * @Given that the username is :username and the accessKey is :accessKey
     */
    public function thatTheUsernameIsAndTheAccesskeyIs($username, $accessKey)
    {
        $this->clientConfiguration = $this->createClientConfiguration($username, $accessKey);

    }

    /**
     * @When I create a new client
     */
    public function iCreateANewClient()
    {
        try {
            $this->client = new Client($this->clientConfiguration);
        } catch (Exception $e)
        {
            // Set the last exception and do nothing
            $this->lastException = $e;
        }

    }

    /**
     * @Then I should get a session id.
     */
    public function iShouldGetASessionId()
    {
        $this->client->getSessionManager()->getSession();
    }

    /**
     * @Then I should get an error with the error :error
     */
    public function iShouldGetAnErrorWithTheError($error)
    {
        $pos = strpos($this->lastException->getMessage(), $error);
        if ($pos === false)
        {
            throw new \Exception(sprintf('Could not find the error %s in the last exception', $error));
        }
    }

    /**
     * @Given that I want to use the :repositoryName repository
     * @param $repositoryName
     */
    public function thatIWantToUseTheRepository($repositoryName)
    {
        $this->currentRepositoryName = $repositoryName;
    }

    /**
     * @When I get the repository by name
     */
    public function iGetTheRepositoryByName()
    {
        try {
            $this->currentRepository = $this->client->getRepositoryByName($this->currentRepositoryName);
        } catch (Exception $e)
        {
            // Set the last exception and do nothing
            $this->lastException = $e;
        }
    }

    /**
     * @Then I should get an :repositoryName repository
     */
    public function iShouldGetAnRepository($repositoryName)
    {
        $expectedRepositoryName = "Vdespa\\Vtiger\\Domain\\Repository\\" . $repositoryName . 'Repository';

        if ($this->currentRepository instanceof $expectedRepositoryName === false)
        {
            throw new \Exception(sprintf('Could not get an instance of the %s repository', $expectedRepositoryName));
        }
    }

    /**
     * @Given that I am using the :arg1 repository
     */
    public function thatIAmUsingTheRepository($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given that I have an :arg1 object
     */
    public function thatIHaveAnObject($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given that its :arg1 is :arg2
     */
    public function thatItsIs($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @When I create the object in the repository
     */
    public function iCreateTheObjectInTheRepository()
    {
        throw new PendingException();
    }

    /**
     * @Then the object should be persisted
     */
    public function theObjectShouldBePersisted()
    {
        throw new PendingException();
    }

    /**
     * @param $username
     * @param $accessKey
     * @return array
     */
    private function createClientConfiguration($username = null, $accessKey = null)
    {
        if ($username === null)
        {
            $username = 'admin'; // FIXME Should read this from the config
        }

        if ($accessKey === null)
        {
            $accessKey = 'GAoZtO4AqMYuiRCs'; // FIXME Should read this from the config
        }

        return [
            'credentials' => [
                'username' => $username,
                'accessKey'=> $accessKey
            ],
            'httpClient' => [
                'base_url' => 'http://vtiger.local/webservice.php'
            ]
        ];
    }
}
