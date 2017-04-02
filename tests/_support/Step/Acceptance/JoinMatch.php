<?php

namespace Step\Acceptance;

class JoinMatch
{
    protected $I;

    function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
    }

    /**
     * @Given there is a new match
     */
    public function thereIsANewMatch()
    {
        $document = $this->I->findDocument('matches', ['name' => self::class]);
        if ($document !== null) {
            $this->I->deleteDocumentById('matches', $document['_id']);
        }

        $this->I->insertDocument('matches', [
            'name' => self::class,
            'updated_at' => $this->I->createMongoDate('Y-m-d H:i:s', '2017-02-20 22:10:51'),
            'created_at' => $this->I->createMongoDate('Y-m-d H:i:s', '2017-02-20 22:10:51'),
            'revision' => 1
        ]);
    }

    /**
     * @Given I am on the new match detail page
     */
    public function iAmOnTheNewMatchDetailPage()
    {
        $document = $this->I->findDocument('matches', ['name' => self::class]);
        $this->I->amOnPage(sprintf('/match/%s', urlencode($document['_id'])));
        $this->I->waitForElement('.loaded', 5);
    }

    /**
     * @When I choose Join for seat 1
     */
    public function iChooseJoinForSeat1()
    {
        $this->I->Click('Join', '.seat-1');
        $this->I->waitForElement('.loaded', 5);
    }

    /**
     * @When I choose Join for seat 2
     */
    public function iChooseJoinForSeat2()
    {
        $this->I->Click('Join', '.seat-2');
        $this->I->waitForElement('.loaded', 5);
    }

    /**
     * @Then seat 1 is taken by me
     */
    public function seat1IsTakenByMe()
    {
        $this->I->see('me logged in', '.seat-1');
    }

    /**
     * @Then seat 1 is not taken by me
     */
    public function seat1IsNotTakenByMe()
    {
        $this->I->dontSee('me logged in', '.seat-1');
    }

    /**
     * @Then seat 2 is taken by me
     */
    public function seat2IsTakenByMe()
    {
        $this->I->see('me logged in', '.seat-2');
    }

    /**
     * @Then I cannot join seat 1
     */
    public function iCannotJoinSeat1()
    {
        $this->I->dontSee('Join', '.seat-1');
    }

    /**
     * @When seat 1 is taken by another player
     */
    public function seat1IsTakenByAnotherPlayer()
    {
        $this->I->anAccountExistsForNameWithRolePlayer('another_player');
        $anotherPlayer = $this->I->findDocument('accounts', ['name' => 'another_player']);
        $this->I->assertNotNull($anotherPlayer, 'account another_player exists');

        $match = $this->I->findDocument('matches', ['name' => self::class]);
        $match['player1_id'] = (string) $anotherPlayer['_id'];
        $match['revision'] = $match['revision'] + 1;

        $this->I->saveDocument('matches', $match);
    }

    /**
     * @When seat 1 is unassigned
     */
    public function seat1IsUnassigned()
    {
        $match = $this->I->findDocument('matches', ['name' => self::class]);
        $match['player1_id'] = null;
        $match['revision'] = $match['revision'] + 1;

        $this->I->saveDocument('matches', $match);
    }

    /**
     * @When I choose Leave for seat 1
     */
    public function iChooseLeaveForSeat1()
    {
        $this->I->Click('Leave', '.seat-1');
        $this->I->waitForElement('.loaded', 5);
    }

    /**
     * @Then I can join seat 1
     */
    public function iCanJoinSeat1()
    {
        $this->I->see('Join', '.seat-1');
    }

    /**
     * @Then I cannot leave seat 1
     */
    public function iCannotLeaveSeat1()
    {
        $this->I->dontSee('Leave', '.seat-1');
    }

    /**
     * @Then I see an error message that the seat could not be joined
     */
    public function iSeeAnErrorMessageThatTheSeatCouldNotByJoined()
    {
        $this->I->see('Error joining seat', '.alert-danger');
    }

    /**
     * @Then I see an error message that the seat could not be left
     */
    public function iSeeAnErrorMessageThatTheSeatCouldNotByLeft()
    {
        $this->I->see('Error leaving seat', '.alert-danger');
    }

    /**
     * @When I wait for a page refresh
     */
    public function iWaitForAPageRefresh()
    {
        $this->I->wait(4);
    }
}
