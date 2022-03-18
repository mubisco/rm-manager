/// <reference types="cypress" />
describe('GIVEN a login page', () => {
  before(() => {
      cy.visit('http://localhost:3000/login')
  })
  context('WHEN I navigate to', () => {
    it('THEN Should have email, pasword inputs, forgot link and login button disabled', () => {
      cy.get('[data-cy="login-email"]').should('exist');
      cy.get('[data-cy="login-password"]').should('exist');
      cy.get('[data-cy="login-forgot"]').should('exist');
      cy.get('[data-cy="login-button"]').should('exist');
      cy.get('[data-cy="login-button"]').contains('Login').should('be.disabled')
    })
  })
  context('WHEN I fill email field with wrong value', () => {
    before(() => {
      cy.get('[data-cy="login-email"]').type('holakease')
    })
    it('THEN should show lint field with error color', () => {
      cy.get('[data-cy="login-email"]').should('have.class', 'v-input--error')
    })
  })
  context('WHEN I fill email field with valid value', () => {
    before(() => {
      cy.get('[data-cy="login-email"]').clear();
      cy.get('[data-cy="login-email"]').type('xan.bellon@gmail.com')
    })
    it('THEN should show not lint email with error color', () => {
      cy.get('[data-cy="login-email"]').should('not.have.class', 'v-input--error')
    })
  })
  context('WHEN I fill password field', () => {
    before(() => {
      cy.get('[data-cy="login-password"]').type('holakease')
    })
    it('THEN should disable login button', () => {
      cy.get('[data-cy="login-button"]').should('not.be.disabled');
    })
  })
})
