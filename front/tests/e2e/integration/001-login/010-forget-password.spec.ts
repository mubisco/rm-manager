/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

describe('GIVEN a login page', () => {
  before(() => {
    cy.visit(routes.front + '/login')
  })
  context('WHEN I click on forgot password link', () => {
    before(() => {
      cy.get('[data-cy="login-forgot"]').click()
    })
    it('THEN navigate to forgot-password page', () => {
      cy.location('pathname').should('match', /\/forgot-password/);
    })
  })
})
