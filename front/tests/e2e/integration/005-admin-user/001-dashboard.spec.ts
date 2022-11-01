/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

describe('GIVEN a player dashboard', () => {
  before(() => {
    cy.adminLogin()
  })
  context('WHEN I visit dashboard page', () => {
    before(() => {
      cy.visit(routes.front + '/dashboard')
    })
    it('THEN I should see under construction title', () => {
      cy.get('[data-cy="under-construction"]').should('exist')
    })
  })
})
