@join_match
Feature: S007-join-match
  In order to join a match
  As a player
  I need to be able to register myself as a player in a match

  Background:
    Given an account exists for "me logged in" with role Player
    And I switch to account "me logged in"
    And there is a new match
    And I am on the new match detail page

  Scenario: open player spot available
    When I choose Join for seat 1
    Then seat 1 is taken by me

  Scenario: cannot join a seat I already took
    When I choose Join for seat 1
    Then seat 1 is taken by me
    And I cannot join seat 1

  Scenario: cannot join a seat taken by another account
    Given seat 1 is taken by another player
    And I am on the new match detail page
    Then I cannot join seat 1

  Scenario: join multiple seats
    When I choose Join for seat 1
    Then seat 1 is taken by me
    And I choose Join for seat 2
    Then seat 1 is taken by me
    And seat 2 is taken by me

  Scenario: leave seat and join again
    When I choose Join for seat 1
    Then seat 1 is taken by me
    When I choose Leave for seat 1
    Then I can join seat 1
    When I choose Join for seat 1
    Then seat 1 is taken by me

  Scenario: cannot leave seat of another player
    Given seat 1 is taken by another player
    And I am on the new match detail page
    Then I cannot join seat 1
    And I cannot leave seat 1

  Scenario: cannot join seat that is taken between loading and joining
    Given I am on the new match detail page
    And seat 1 is taken by another player
    When I choose Join for seat 1
    Then I see an error message that the seat could not be joined
    And seat 1 is not taken by me

  Scenario: cannot leave seat that is left between loading and joining
    When I choose Join for seat 1
    Then seat 1 is taken by me
    When seat 1 is unassigned
    And I choose Leave for seat 1
    Then I see an error message that the seat could not be left
    And seat 1 is not taken by me

  Scenario: I can see another player joined without a manual page refresh
    Given I am on the new match detail page
    Then seat 1 is unassigned
    When seat 1 is taken by another player
    And I wait for a page refresh
    Then I cannot join seat 1
