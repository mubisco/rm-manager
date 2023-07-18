Feature:
  In order to create characters
  As a user
  I want to get profession names

  Scenario: Anon users should not receive data
    Given A anon user
    When I check endpoint "/api/en/character/profession/names" with "GET"
    Then I should get an unauthorized response

  Scenario: User should receive proper data
    Given A authorized user
    When I check endpoint "/api/en/character/profession/names" with "GET"
    Then I should get profession names response
