/// <reference types="cypress" />
describe('GIVEN a login page', () => {
  describe('WHEN I navigate to', () => {
    it('Should have email, pasword inputs, forgot link and login button disabled', () => {
      cy.visit('http://localhost:3000/login')
      cy.get('[data-cy="login-email"]').should('exist');
      cy.get('[data-cy="login-password"]').should('exist');
      cy.get('[data-cy="login-forgot"]').should('exist');
      cy.get('[data-cy="login-button"]').should('exist');
      cy.get('[data-cy="login-button"]').contains('Login').should('be.disabled')
    })
  });
});
