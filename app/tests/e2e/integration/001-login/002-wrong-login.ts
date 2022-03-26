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
        statusCode: 401
      })
      cy.customLogin('bad_user', 'holakease')
    })
    it('THEN should show error toast', () => {
      cy.get('[data-cy="login-error"]').should('exist');
    })
  })
})
