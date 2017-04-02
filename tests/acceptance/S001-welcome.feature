@welcome
Feature: S001-welcome
  In order to find out what this application has to offer
  As a potential player
  I need to to be able the read the title and description of this application

  Scenario: try welcome
    When I am on the welcome page
    Then I should see the title "Dominoes Again!"
    And I should see the description
