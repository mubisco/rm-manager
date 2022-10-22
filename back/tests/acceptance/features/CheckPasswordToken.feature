Feature:
  In order to change my password
  As a non-auth user
  I want to check if my reset token is valid

  Scenario:
    Given A non-auth user with a non existant token
    When I check the token validity
    Then I should get the response from token not valid

  Scenario:
    Given A non-auth user with an expired token
    When I check the token validity
    Then I should get the response from token expired

