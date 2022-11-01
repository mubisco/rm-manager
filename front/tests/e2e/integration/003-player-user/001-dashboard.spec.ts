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
    it('AND THEN I should see my games list', () => {
      cy.get('[data-cy="mygames-table"]').should('exist')
    })
  })
})
