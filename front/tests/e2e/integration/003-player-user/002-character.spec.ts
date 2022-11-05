/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

describe('GIVEN a player dashboard', () => {
  beforeEach(() => {
    cy.playerLogin()
  })
  context('WHEN I visit dashboard page', () => {
    before(() => {
      cy.visit(routes.front + '/dashboard')
    })
    it('THEN I should see the character details button', () => {
      cy.get('[data-cy="character-details-btn"]').should('exist')
    })
  })
  context('WHEN I click on details button', () => {
    before(() => {
      cy.visit(routes.front + '/dashboard')
    })
    it('THEN I should go to character main page', () => {
      cy.get('[data-cy="character-details-btn"]').click()
      cy.location('pathname').should('match', /\/character/)
    })
  })
})
