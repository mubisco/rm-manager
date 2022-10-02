Feature:
  In order to acces the application
  As a non-auth user
  I want to reset my password

  Scenario: Non existant user
    Given A non existant user
    When I want to reset my password
    Then I should receive a "404" response

  Scenario: No user data
    When I want to reset my password with no data
    Then I should receive a "400" response

  Scenario: An existing user
    Given A existing user
    When I want to reset my password
    Then I should receive a "200" response
    And The user should have reset password token

