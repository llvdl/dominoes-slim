<?php

namespace Step\Acceptance;

class CreateAccount
{
    protected $I;

    public function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
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
     * @Given I am on the welcome page
     */
    public function iAmOnTheWelcomePage()
    {
        $this->I->amOnPage('/');
    }

    /**
     * @Then I should see the account creation form
     */
    public function iShouldSeeTheAccountCreationForm()
    {
        $this->I->see('Create new account', 'form');
    }

    /**
     * @Then I enter the e-mail :arg1
    */
    public function iEnterTheEmail($arg1)
    {
        $this->I->fillField('email', $arg1);
    }

    /**
     * @Then I enter the password :arg1
    */
    public function iEnterThePassword($arg1)
    {
        $this->I->fillField('password', $arg1);
        $this->I->fillField('password-repeat', $arg1);
    }

    /**
     * @Then I see account name :arg1
     */
    public function iSeeAccountName($arg1)
    {
        $this->I->see($arg1, '.account-name');
    }

    /**
     * @Then I see "Account created"
     */
    public function isSeeAccountCreated()
    {
        $this->I->see('Account created', '.alert');
    }

    /**
     * @Then I see "Account name is already in use."
     */
    public function isSeeAccountNameIsAlreadyInUse()
    {
        $this->I->see('Account name is already in use.', '.error');
    }

    /**
     * @When I enter a different value for password and repeat password
     */
    public function iEnterADifferentValueForPasswordAndRepeatPassword()
    {
        $this->I->fillField('password', 's3cr3t');
        $this->I->fillField('password-repeat', 'Secret');
    }

    /**
     * @Then I see "Password and repeated password do not match"
     */
    public function iSeePasswordAndRepeatedPasswordDoNotMatch()
    {
        $this->I->see('Password and repeated password do not match', '.error');
    }
}
