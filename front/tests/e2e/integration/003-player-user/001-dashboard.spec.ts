/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

describe('GIVEN a player dashboard', () => {
  before(() => {
    cy.playerLogin()
  })
  context('WHEN I visit dashboard page', () => {
    before(() => {
      cy.visit(routes.front + '/dashboard')
    })
    it('THEN I should see my character list', () => {
      cy.get('[data-cy="mypc-table"]').should('exist')
    })
  })
})
