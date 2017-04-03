<?php

namespace Step\Acceptance;

class MatchOverview
{
    protected $I;

    public function __construct(\AcceptanceTester $I)
    {
        $this->I = $I;
    }

    /**
     * @When there is an existing match
     */
    public function thereIsAnExistingMatch()
    {
        $document = $this->I->findDocument('matches', ['name' => 'Some match']);
        if ($document !== null) {
            return;
        }

        $this->I->insertDocument('matches', [
            "name" => "Some match",
            "updated_at" => $this->I->createMongoDate('Y-m-d H:i:s', '2017-02-20 22:10:51'),
            "created_at" => $this->I->createMongoDate('Y-m-d H:i:s', '2017-02-20 22:10:51'),
            'state' => 'new',
            'revision' => 1
        ]);
    }

    /**
     * @Then I see the match overview page
     */
    public function iShouldSeeTheMatchOverviewPage()
    {
        $this->I->see('Match overview', 'h1');
    }

    /**
     * @Then I see at least one match
     */
    public function iSeeAtLeastOneMatch()
    {
        $this->I->waitForElement('.loaded', 3);
        $this->I->expect('to see a match named "Some match"');
        $this->I->see('Some match', '.match');
    }

    /**
     * @Then I see no matches
     */
    public function iSeeNoMatches()
    {
        $this->I->waitForElement('.loaded', 5);
        $this->I->expect('to see no matches at all');
        $this->I->dontSeeElement('#match-overview a.match');
        $this->I->seeElement('.no-matches-found');
    }
}
