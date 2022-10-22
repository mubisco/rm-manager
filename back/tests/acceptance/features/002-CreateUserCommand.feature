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
    And The user must have proper <roles>
      | ROLE_USER |

  Scenario: Create a user with master permissions
    Given A sys admin with console access
    When I create a user with name "agapito", mail "test@test.com", password "simple-password" and role "ROLE_MASTER"
    Then I should see "User created successfully" message
    And I should have a user with proper data
    And The user must have proper <roles>
      | ROLE_USER,ROLE_MASTER |

  Scenario: Create a user with admin permissions
    Given A sys admin with console access
    When I create a user with name "agapito", mail "test@test.com", password "simple-password" and role "ROLE_ADMIN"
    Then I should see "User created successfully" message
    And I should have a user with proper data
    And The user must have proper <roles>
      | ROLE_USER,ROLE_ADMIN |
