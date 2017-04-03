<?php

namespace Step\Acceptance;

class CreateMatch
{
    protected $I;

    public function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
    }

    /**
     * @Then I should see the match creation form
     */
    public function iShouldSeeTheMatchCreationForm()
    {
        $this->I->see('Create new match', 'form');
    }

    /**
     * @When I enter the name :arg1
     */
    public function iEnterTheName($arg1)
    {
        $this->I->fillField('name', $arg1);
    }

    /**
     * @When submit the form
     */
    public function submitTheForm()
    {
        $this->I->click('Create');
    }

    /**
     * @Then I am on the match detail page
     */
    public function iAmOnTheMatchDetailPage()
    {
        $this->I->see('Match details');
    }

    /**
     * @Then I see match name :arg1
     */
    public function iSeeMatchName($arg1)
    {
        $this->I->see($arg1, '.name');
    }

    /**
     * @Then I see the match identification code
     */
    public function iSeeTheMatchIdentificationCode()
    {
        $this->I->seeElement('.match-id');

        $id = $this->I->grabTextFrom('.match-id');
        $this->I->assertNotEmpty($id, 'id may not be empty');
    }

    /**
     * @When I open the detail page of a non-existing game
     */
    public function iOpenTheDetailPageOfANonExistingMatch()
    {
        $this->I->amOnPage('/match/0008002477af9516e753eec8');
    }
}
