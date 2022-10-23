Feature:
  In order to change my password
  As a non-auth user
  I want to change my password

  Scenario:
    Given A non-auth user with a non existant token
    When I check the token validity
    Then I should get the response from token not valid

  Scenario:
    Given A non-auth user with an expired token
    When I check the token validity
    Then I should get the response from token expired

  Scenario:
    Given A non-auth user with a valid token
    When I check the token validity
    Then I should get OK response

  Scenario:
    Given A non-auth user with a valid checked token
    When I request the password change
    Then The user should have password updated

