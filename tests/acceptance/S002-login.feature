@welcome @account
Feature: S002-login
  In order log in
  As a player
  I need to be enter my credentials

  Background:
    Given I am on the welcome page
    And I have an account

  Scenario: log in and log out
    Then I see "Log In"
    When I press "Log In"
    Then I see the log in page
    When I enter correct credentials
    Then I get back at the home page
    And I see my account name

    When I press "My Name"
    And I press "Log Out"
    Then I get back at the home page
    And I don't see my account name
    And I see "Log In"

    Scenario: wrong credentials
      Then I see "Log In"
      When I press "Log In"
      Then I see the log in page
      When I enter incorrect credentials
      Then I see an error message for incorrect credentials
      And I don't see my account name
