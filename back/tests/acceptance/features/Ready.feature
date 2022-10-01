Feature:
  In order to prove api is ready
  As a user
  I want to check api responses

  Scenario: It returns api is ready
    When I make a request to "/api/ready"
    Then I should have a response
    And The response should be show the ready message

