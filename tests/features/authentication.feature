Feature: Authentication
  In order to make authenticated requests
  As an API user
  I need to be able to have a valid session in order to make authenticated requests

  Scenario: Valid credentials
    Given that the username is "admin" and the accessKey is "GAoZtO4AqMYuiRCs"
    When I create a new client
    Then I should get a session id.

  Scenario: Bad credentials
    Given that the username is "admin" and the accessKey is "badAccessKey"
    When I create a new client
    Then I should get an error with the error "INVALID_USER_CREDENTIALS"

