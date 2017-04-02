<?php

namespace Step\Acceptance;

use MongoDB\Operation\DeleteOne;

class Account
{
    protected $I;

    public function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
    }

    /**
     * @When I have an account
     */
    public function iHaveAnAccount()
    {
        $this->I->insertDocument('accounts', [
            "name" => "My Name",
            "e-mail" => "my-name@test.com",
            "password_hash" => password_hash('1234', PASSWORD_DEFAULT),
            "is_active" => true,
            "updated_at" => $this->I->createMongoDate('Y-m-d H:i:s', '2017-02-20 22:10:51'),
            "created_at" => $this->I->createMongoDate('Y-m-d H:i:s', '2017-02-20 22:10:51')
        ]);
    }

    /**
     * @Then I see the log in page
     */
    public function iSeeTheLogInPage()
    {
        $this->I->amOnPage('/login');
    }

    /**
     * @When I press "Log in"
     */
    public function iPressLogIn()
    {
        $this->I->press("Log In");
    }

    /**
     * @When I enter correct credentials
     */
    public function iEnterTheCorrectCredentials()
    {
        $this->I->fillField('name', 'My Name');
        $this->I->fillField('password', '1234');
        $this->I->click('Log In');
    }

    /**
     * @When I enter incorrect credentials
     */
    public function iEnterIncorrectCredentials()
    {
        $this->I->fillField('name', 'My Name');
        $this->I->fillField('password', 'bad & wrong');
        $this->I->click('Log In');
    }

    /**
     * @Then I get back at the home page
     */
    public function iGetBackAtTheHomePage()
    {
        $this->I->amOnPage('/');
    }

    /**
     * @Then I see my account name
     */
    public function iSeeMyAccountName()
    {
        $this->I->see('My Name', '.account-name');
    }

    /**
     * @Then I don't see my account name
     */
    public function iDontSeeMyAccountName()
    {
        $this->I->dontSee('My Name', '.account-name');
    }

    /**
     * @Then I see "Log In"
     */
    public function iSeeLogIn()
    {
        $this->I->see('Log In', 'a');
    }

    /**
     * @Then I see an error message for incorrect credentials
     */
    public function iSeeAnErrorMessageForIncorrectCredentials()
    {
        $this->I->see('Invalid credentials', '.alert-danger');
    }
}
