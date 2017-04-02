@welcome @create_match
Feature: S006-create-match
  In order to create a match
  As a game master
  I need to fill in the game creation form
  And then submit the game creation form

  Scenario: try S006-create-game
    Given I am on the welcome page
    When I press "Create new match"
    Then I should see the match creation form

    When I enter the name "My first match"
    And submit the form
    Then I am on the match detail page
    And I see match name "My first match"
    And I see the match identification code

  Scenario: opening detail of non-existing game
    Given I am on the welcome page
    When I open the detail page of a non-existing game
    Then I see a page not found error
