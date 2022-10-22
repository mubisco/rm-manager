/// <reference types="cypress" />

// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

import tokens from '../fixtures/tokens.json'
import routes from '../fixtures/routes.json'

Cypress.Commands.add('customLogin', (email: string, password: string): void => {
  cy.get('[data-cy="login-username"]').type(email)
  cy.get('[data-cy="login-password"]').type(password)
  cy.get('[data-cy="login-button"]').click()
})

Cypress.Commands.add('adminLogin', (): void => {
  cy.intercept(routes.back + '/api/login', (req) => {
    req.reply({
      statusCode: 200,
      body: { token: tokens.admin, refresh_token: 'aVeryLargeToken' }
    })
  }).as('adminLoginRoute')
  cy.visit(routes.front + '/login')
  cy.get('[data-cy="login-username"]').type('username')
  cy.get('[data-cy="login-password"]').type('aPassword')
  cy.get('[data-cy="login-button"]').click()
})
