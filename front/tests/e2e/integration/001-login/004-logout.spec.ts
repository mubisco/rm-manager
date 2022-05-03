/// <reference types="cypress" />

import routes from '../../fixtures/routes.json'
import tokens from '../../fixtures/tokens.json'

describe('GIVEN a logged page', () => {
  beforeEach(() => {
    cy.intercept(routes.back + '/api/login', (req) => {
      req.reply({
        statusCode: 200,
        body: {token: tokens.admin },
        delay: 500,
      })
    }).as('loginRoute');
    cy.visit(routes.front + '/login')
    cy.customLogin('mubisco', 'password')
  })
  context('WHEN I successfully login', () => {
    it('THEN I should see logout button on top bar', () => {
      cy.get('[data-cy="logout-top-button"]').should('exist')
    })
    it('AND THEN I should see logout button on left menu', () => {
      cy.get('[data-cy="logout-left-button"]').should('exist')
    })
  })
  context('WHEN I click on top logout button login', () => {
    beforeEach(() => {
      cy.get('[data-cy="logout-top-button"]').click()
    })
    it('THEN I should return to login page', () => {
      cy.location('pathname').should('match', /\/login/);
    })
    it('AND THEN I should see logout button on top menu', () => {
      cy.get('[data-cy="login-top-button"]').should('exist')
    })
    it('AND THEN user data should not be stored', () => {
      const rawUserData = localStorage.getItem('userData')
      expect(rawUserData).to.be.null
    })
  })
  context('WHEN I click on left logout button login', () => {
    beforeEach(() => {
      cy.get('[data-cy="logout-left-button"]').click({ force: true })
    })
    it('THEN I should return to login page', () => {
      cy.location('pathname').should('match', /\/login/);
    })
    it('AND THEN I should see logout button on top menu', () => {
      cy.get('[data-cy="login-left-button"]').should('exist')
    })
    it('AND THEN user data should not be stored', () => {
      const rawUserData = localStorage.getItem('userData')
      expect(rawUserData).to.be.null
    })
  })
})
