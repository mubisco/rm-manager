Feature:
  In order to create characters
  As a user
  I want to get profession data

  Scenario: Anon users should not receive data
    Given A anon user
    When I check endpoint "/api/en/character/profession/cleric" with "GET"
    Then I should get an unauthorized response

  Scenario: User should receive proper data
    Given A authorized user
    When I check endpoint "/api/en/character/profession/cleric" with "GET"
    Then I should get profession data response

  Scenario: User should receive not found info if profession does not exists
    Given A authorized user
    When I check endpoint "/api/en/character/profession/non-existant" with "GET"
    Then I should get an not-found code

