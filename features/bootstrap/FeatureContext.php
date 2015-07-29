<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once __DIR__ . '/../../vendor/autoload.php';

define('APPLICATION_ENV', 'testing');
define('APPLICATION_PATH', dirname(__FILE__) . '/../../application');

require_once dirname(__FILE__) . '/../application/ControllerTestCase.php';

class FeatureContext extends BehatContext
{

    protected $app;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set up via behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->app = new ControllerTestCase();
        $this->app->setUp();
    }

    /**
     * @When /^I load the URL "([^"]*)"$/
     */
    public function iLoadTheURL($url)
    {
        $this->app->dispatch($url);
    }

    /**
     * @Then /^the module should be "([^"]*)"$/
     */
    public function theModuleShouldBe($desiredModule)
    {
        $this->app->assertModule($desiredModule);
    }

    /**
     * @Given /^the controller should be "([^"]*)"$/
     */
    public function theControllerShouldBe($desiredController)
    {
        $this->app->assertController($desiredController);
    }

    /**
     * @Given /^the action should be "([^"]*)"$/
     */
    public function theActionShouldBe($desiredAction)
    {
        $this->app->assertAction($desiredAction);
    }

    /**
     * @Given /^the page should contain a "([^"]*)" tag that contains "([^"]*)"$/
     */
    public function thePageShouldContainATagThatContains($tag, $content)
    {
        $this->app->assertQueryContentContains($tag, $content);
    }

    /**
     * @Given /^the action should not redirect$/
     */
    public function theActionShouldNotRedirect()
    {
        $this->app->assertNotRedirect();
    }
    
    /**
     * @Given /^the action should redirect to "([^"]*)"$/
     */
    public function theActionShouldRedirectTo($newUrl)
    {
        $this->app->assertRedirectTo($newUrl);
    }


}
