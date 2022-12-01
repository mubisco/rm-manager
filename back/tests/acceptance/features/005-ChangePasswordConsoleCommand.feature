Feature:
    In order to change user password
    As a sys admin with console access
    I want to update User password

    Scenario: Command should fail when bad user targeted
      Given A sys admin with console access
      When I try to update password of a non existing user
      Then I should get an error

    Scenario: Command should succeed when existing user
      Given A sys admin with console access
      When I try to update password of an existing user
      Then I should get an success message
      And password should be changed

