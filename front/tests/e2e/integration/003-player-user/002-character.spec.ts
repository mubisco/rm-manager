/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

describe('GIVEN a player dashboard', () => {
  context('WHEN I visit dashboard page', () => {
    before(() => {
      cy.playerLogin()
      cy.visit(routes.front + '/dashboard')
    })
    it('THEN I should see the character details button', () => {
      cy.get('[data-cy="character-details-btn"]').should('exist')
    })
  })
  context('WHEN I click on details button', () => {
    before(() => {
      cy.playerLogin()
      cy.visit(routes.front + '/dashboard')
      cy.get('[data-cy="character-details-btn"]').click()
    })
    it('THEN I should go to character main page', () => {
      cy.location('pathname').should('match', /\/character/)
    })
    it('AND THEN I should see character tab menu', () => {
      cy.get('[data-cy="character-tab-menu"]').should('exist')
    })
  })
})
