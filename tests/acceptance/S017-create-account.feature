@welcome @create_account
Feature: S017-create-account
  In order to create an account
  As a user
  I need to fill in the account creation form
  And then submit the account creation form

  Background:
    Given I am on the welcome page
    When I press "Create new account"
    Then I should see the account creation form

  Scenario: create new account
    When I enter the name "A Dominoes Player"
    And I enter the e-mail "dominoes@test.nl"
    And I enter the password "S3cr3t!!"
    And submit the form
    Then I see "Account created"

  Scenario: account name already exists
      When I enter the name "A Dominoes Player"
      And I enter the e-mail "dominoes@test.nl"
      And I enter the password "S3cr3t!!"
      And submit the form
      Then I see "Account name is already in use."

  Scenario: password and password repeat mismatch
    When I enter a different value for password and repeat password
    And submit the form
    Then I see "Password and repeated password do not match"
