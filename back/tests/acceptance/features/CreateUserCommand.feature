Feature:
  In order to be able to create Tests
  As a sys admin with access to Console
  I want to create a User

  Scenario: Create a user with only user permissions
    Given A sys admin with console access
    When I create a user with name "agapito", mail "test@test.com", password "simple-password" and role "ROLE_USER"
    Then I should see "User created successfully" message
    And I should have a user with proper data
    And One event must be dispatched
