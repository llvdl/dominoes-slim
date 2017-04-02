<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * @Then I see a page not found error
     */
    public function iSeeAPageNotFoundError()
    {
        $this->see('Page Not Found');
    }

    /**
     * @Given an account exists for :name with role Player
     */
    public function anAccountExistsForNameWithRolePlayer($name)
    {
        if ($this->findDocument('accounts', ['name' => $name]) === null) {
            $now = new \DateTime();

            $this->insertDocument('accounts', [
                "name" => $name,
                "e-mail" => bin2hex(random_bytes(4)) . '@test.com',
                "password_hash" => password_hash('1234', PASSWORD_DEFAULT),
                "is_active" => true,
                "updated_at" => $this->createMongoDate('Y-m-d H:i:s', $now->format('Y-m-d H:i:s')),
                "created_at" => $this->createMongoDate('Y-m-d H:i:s', $now->format('Y-m-d H:i:s'))
            ]);
        }
    }

    /**
     * @When I switch to account :name
     */
    public function iSwitchToAccount($name)
    {
        $account = $this->findDocument('accounts', ['name' => $name]);

        $this->assertNotNull($account, sprintf('account "%s" must exist', $name));

        $this->amOnPage('/log-in-as/' . $account['_id']);
        $this->see('Logged in as ' . $account['_id']);
    }

    public function getAccountId($name): string
    {
        $account = $this->findDocument('accounts', ['name' => $name]);

        $this->assertNotNull($account, sprintf('account "%s" must exist', $name));

        return $account['_id'];
    }
}
