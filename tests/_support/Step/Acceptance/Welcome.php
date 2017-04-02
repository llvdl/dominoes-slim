<?php

namespace Step\Acceptance;

class Welcome
{
    protected $I;

    function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
    }

    /**
     * @Given I am on the welcome page
     */
    public function iAmOnTheWelcomePage()
    {
        $this->I->amOnPage('/');
    }

    /**
     * @When I press :arg1
     */
    public function iPress($arg1)
    {
        $this->I->click($arg1);
    }

    /**
     * @Then I should see the title :arg1
     */
    public function iShouldSeeTheTitle($arg1)
    {
        $this->I->see('Dominoes Again!');
    }

    /**
     * @Then I should see the description
     */
    public function iShouldSeeTheDescription()
    {
        $this->I->see('Welcome', '.description');
    }
}
