/// <reference types="cypress" />
import { Given, Then } from "cypress-cucumber-preprocessor/steps";
//Navigate to URl
const url = 'http://localhost:3000/login'

Given('I open login page', () => {
  cy.visit(url)
});


Then('I should see login form', () => {
  cy.get('[data-cy="login-email"]').should('not.exist');
  cy.get('[data-cy="login-password"]').should('exist');
  cy.get('[data-cy="login-forgot"]').should('exist');
  cy.get('[data-cy="login-button"]').should('exist');
  cy.get('[data-cy="login-button"]').contains('Login').should('be.disabled')
});

