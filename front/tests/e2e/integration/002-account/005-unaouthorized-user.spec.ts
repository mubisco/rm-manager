/// <reference types="cypress" />

import routes from '../../fixtures/routes.json'

describe('GIVEN a unauthenticated user', () => {
  context('WHEN I try to access admin dashboard', () => {
    before(() => {
      cy.visit(routes.front + '/dashboard')
    })
    it('THEN I should see Unauthorized page', () => {
      cy.location('pathname').should('match', /\/login/)
    })
  })
})
