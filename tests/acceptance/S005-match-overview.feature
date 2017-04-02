@welcome @match_overview
Feature: S005-open-list-of-open-matches
  In order to find a match to join
  As a player
  I need to be able to access the list of open matches

  Background:
    Given I am on the welcome page

  Scenario: there are no matches
    When I press "Match overview"
    Then I see the match overview page
    And I see no matches

  Scenario: there is at least one match
    Given there is an existing match
    When I press "Match overview"
    Then I see the match overview page
    And I see at least one match
