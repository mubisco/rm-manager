/// <reference types="cypress" />
describe('GIVEN a login page', () => {
  before(() => {
      cy.visit('http://localhost:3000/login')
  })
  context('WHEN I click login button with proper params', () => {
    before(() => {
      cy.intercept('POST', '/api/login', {
        delay: 500,
        body: { token: 'some-token' },
        statusCode: 200
      }).as('loginRoute');
      cy.get('[data-cy="login-email"]').type('xan.bellon@gmail.com')
      cy.get('[data-cy="login-password"]').type('holakease')
      cy.get('[data-cy="login-button"]').click();
    })
    it('THEN should navigate to dashboard page', () => {
      cy.location('pathname').should('match', /\/dashboard/);
    })
  })
})
