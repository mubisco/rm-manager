/// <reference types="cypress" />
describe('GIVEN a login page', () => {
  before(() => {
      cy.visit('http://localhost:3000/login')
  })
  context('WHEN I click login button with wrong params', () => {
    before(() => {
      cy.intercept('POST', '/api/login', {
        delay: 500,
        body: { message: 'NOT_AUTH' },
        statusCode: 403
      }).as('loginRoute');
      cy.get('[data-cy="login-email"]').type('xan.bellon@gmail.com')
      cy.get('[data-cy="login-password"]').type('holakease')
      cy.get('[data-cy="login-button"]').click();
    })
    it('THEN should show error toast', () => {
      cy.get('[data-cy="login-error"]').should('exist');
    })
  })
})
