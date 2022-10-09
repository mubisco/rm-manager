/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

describe('GIVEN a login page', () => {
  before(() => {
    cy.visit(routes.front + '/login')
  })
  context('WHEN I click login button with wrong params', () => {
    before(() => {
      cy.intercept('POST', routes.back + '/api/login', {
        delay: 500,
        body: { message: 'NOT_AUTH' },
        statusCode: 401
      }).as('loginUrl')
      cy.customLogin('bad_user', 'holakease')
    })
    it('THEN should show error toast', () => {
      cy.wait('@loginUrl').then(() => {
        cy.get('[data-cy="login-error"]').should('exist');
      })
    })
  })
})
