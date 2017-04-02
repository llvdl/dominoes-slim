@start_match

Feature: S008-start-match
  In order to start a match
  As a user
  I have to go to game detail page of a game I created
  And press start when all seats have been taken

  Background:
    Given an account exists for "player1" with role Player
    And I switch to account "player1"
    And I have created a game
    And no one has joined yet

  Scenario: start game
    When I am on the match detail page
    Then the start button is disabled
    When all seats are taken by "player1"
    And I wait for the page to refresh
    Then the start button is enabled
