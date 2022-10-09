/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

describe('GIVEN a login page', () => {
  before(() => {
    cy.visit(routes.front + '/login')
  })
  context('WHEN I navigate to', () => {
    it('THEN Should have username, pasword inputs, forgot link and login button disabled', () => {
      cy.get('[data-cy="login-username"]').should('exist');
      cy.get('[data-cy="login-password"]').should('exist');
      cy.get('[data-cy="login-forgot"]').should('exist');
      cy.get('[data-cy="login-button"]').should('exist');
      cy.get('[data-cy="login-button"]').should('be.disabled')
    })
  })
  context('WHEN I fill username field with wrong value', () => {
    before(() => {
      cy.get('[data-cy="login-username"]').type('xaninverno@server.net')
    })
    it('THEN should show lint field with error color', () => {
      cy.get('[data-cy="login-username"]').should('have.class', 'v-input--error')
    })
  })
  context('WHEN I fill username field with valid value', () => {
    before(() => {
      cy.get('[data-cy="login-username"]').clear();
      cy.get('[data-cy="login-username"]').type('username')
    })
    it('THEN should show not lint username with error color', () => {
      cy.get('[data-cy="login-username"]').should('not.have.class', 'v-input--error')
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
  context('WHEN I click login button', () => {
    before(() => {
      cy.intercept('POST', routes.back + '/api/login', { delay: 500 }).as('loginRoute');
      cy.get('[data-cy="login-button"]').click();
    })
    it('THEN should show loading icon', () => {
      cy.get('[data-cy="login-button"]').get('i').should('exist')
    })
  })
})
