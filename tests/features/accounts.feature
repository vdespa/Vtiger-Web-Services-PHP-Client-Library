Feature: Accounts
  In order to access the Accounts module
  As an API user
  I need to be able to perform various tasks on the Accounts module

  Scenario: Access the accounts repository
    Given that I am authenticated
    And that I want to use the "Accounts" repository
    When I get the repository by name
    Then I should get an "Accounts" repository

  Scenario: Create a new Account.
    Given that I am authenticated
    And that I am using the "Accounts" repository
    And that I have an "Account" object
    And that its "name" is "My Cool Company"
    When I create the object in the repository
    Then the object should be persisted