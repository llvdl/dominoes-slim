<?php

namespace Step\Acceptance;

use Illuminate\Database\Console\Migrations\RefreshCommand;

class StartMatch
{
    protected $I;

    public function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
    }

    /**
     * @Given I have created a game
     */
    public function iHaveCreatedAGame()
    {
        $document = $this->I->findDocument('matches', ['name' => self::class]);
        if ($document !== null) {
            $this->I->deleteDocumentById('matches', $document['_id']);
        }

        $this->I->insertDocument('matches', [
            'name' => self::class,
            'updated_at' => $this->I->createMongoDate('Y-m-d H:i:s', '2017-02-20 22:10:51'),
            'created_at' => $this->I->createMongoDate('Y-m-d H:i:s', '2017-02-20 22:10:51'),
            'state' => 'new',
            'revision' => 1
        ]);
    }

    /**
     * @When no one has joined yet
     */
    public function noOneHasJoinedYet()
    {
        $document = $this->I->findDocument('matches', ['name' => self::class]);
        if ($document === null) {
            throw new \Exception('expected game to be already created');
        }

        $document['player1_id'] = null;
        $document['player2_id'] = null;
        $document['player3_id'] = null;
        $document['player4_id'] = null;

        ++$document['revision'];

        $this->I->saveDocument('matches', $document);
    }

    /**
     * @Given I am on the match detail page
     */
    public function iAmOnTheMatchDetailPage()
    {
        $document = $this->I->findDocument('matches', ['name' => self::class]);
        $this->I->amOnPage(sprintf('/match/%s', urlencode($document['_id'])));
        $this->I->waitForElement('.loaded', 5);
    }

    /**
     * @Then the start button is disabled
     */
    public function theStartButtonIsDisabled()
    {
        $this->I->see('Start', 'button.disabled');
    }

    /**
     * @When all seats are taken by :name
     */
    public function allSeatsAreTakenBy($name)
    {
        $document = $this->I->findDocument('matches', ['name' => self::class]);
        if ($document === null) {
            throw new \Exception('expected game to be already created');
        }

        $accountId = $this->I->getAccountId($name);

        $document['player1_id'] = $accountId;
        $document['player2_id'] = $accountId;
        $document['player3_id'] = $accountId;
        $document['player4_id'] = $accountId;

        ++$document['revision'];

        $this->I->saveDocument('matches', $document);
    }

    /**
     * @When I wait for the page to refresh
     */
    public function iWaitForThePageToRefresh()
    {
        $this->I->wait(4);
    }

    /**
     * @Then the start button is enabled
     */
    public function theStartButtonIsEnabled()
    {
        $this->I->dontSee('Start', 'button.disabled');
        $this->I->see('Start', 'button');
    }

    /**
     * @Then I see the game has not started
     */
    public function iSeeTheGameHasNotStarted()
    {
        $this->I->See('Match has not been started.');
    }

    /**
     * @Then I see the game has not started
     */
    public function iSeeTheGameHasStarted()
    {
        $this->I->dontSee('Match is in progress.');
    }

    /**
     * @When I press the start button
     */
    public function iPressTheStartButton()
    {
        $this->I->click('Start');
    }

    /**
     * @Then the start button is not shown
     */
    public function theStartButtonIsNotShown()
    {
        $this->I->dontSee('Start', 'button');
    }

    /**
     * @Then there are no leave buttons
     */
    public function thereAreNoLeaveButtons()
    {
        $this->I->dontSee('Leave', 'button');
    }
}
