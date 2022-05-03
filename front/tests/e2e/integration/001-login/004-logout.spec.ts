/// <reference types="cypress" />

import routes from '../../fixtures/routes.json'
import tokens from '../../fixtures/tokens.json'

describe('GIVEN a login page', () => {
  before(() => {
    cy.visit(routes.front + '/login')
  })
  context('WHEN I successfully login', () => {
    before(() => {
      cy.intercept(routes.back + '/api/login', (req) => {
        req.reply({
          statusCode: 200,
          body: {token: tokens.admin },
          delay: 500,
        })
      }).as('loginRoute');
      cy.customLogin('mubisco', 'password')
    })
    it('THEN I should see logout button on top bar', () => {
      cy.get('[data-cy="logout-top-button"]').should('exist')
    })
    it('AND THEN I should see logout button on left menu', () => {
      cy.get('[data-cy="logout-left-button"]').should('exist')
    })
  })
})
