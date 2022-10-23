/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

describe('GIVEN an unauthenticated user', () => {
  context('WHEN I navigate to recover-password page', () => {
    before(() => {
      cy.visit(routes.front + '/forgot-password')
    })
    it('THEN I should see update password input form', () => {
      cy.get('[data-cy="recover-password-form"]').should('exist')
      cy.get('[data-cy="recover-password-input"]').should('exist')
      cy.get('[data-cy="recover-password-button"]').should('exist')
      cy.get('[data-cy="recover-password-button"]').should('be.disabled')
    })
  })
})

describe('GIVEN an authenticated user', () => {
  before(() => {
    cy.adminLogin()
  })
  context('WHEN I navigate to recover password page', () => {
    before(() => {
      cy.visit(routes.front + '/forgot-password')
    })
    it('THEN I should be redirected to dashboard', () => {
      cy.location('pathname').should('match', /\/dashboard/)
    })
  })
  after(() => {
    cy.get('[data-cy="logout-top-button"]').click()
  })
})

describe('GIVEN a recover password page', () => {
  beforeEach(() => {
    cy.visit(routes.front + '/forgot-password')
  })
  context('WHEN I enter something on the input field', () => {
    beforeEach(() => {
      cy.get('[data-cy="recover-password-input"]').type('someUsername')
    })
    it('THEN confirm button should be enabled', () => {
      cy.get('[data-cy="recover-password-button"]').should('be.enabled')
    })
  })
  context('WHEN I enter a non existent user', () => {
    beforeEach(() => {
      cy.intercept(routes.back + '/api/user/reset-password', (req) => {
        req.reply({
          statusCode: 404,
          body: { error: 'User does not exists' },
          delay: 500
        })
      }).as('recoverPasswordRoute')
      cy.get('[data-cy="recover-password-input"]').type('notExistantUser')
    })
    it('THEN I should see an error message', () => {
      cy.get('[data-cy="recover-password-button"]').click()
      cy.wait('@recoverPasswordRoute').then(() => {
        cy.get('[data-cy="snackbar-message"]').should('exist')
        cy.get('[data-cy="snackbar-message"]').contains('Usuario')
      })
    })
  })
  context('WHEN there is an error on server', () => {
    beforeEach(() => {
      cy.intercept(routes.back + '/api/user/reset-password', (req) => {
        req.reply({
          statusCode: 500,
          body: { error: 'UnexpectedError' },
          delay: 500
        })
      }).as('recoverPasswordRoute')
      cy.get('[data-cy="recover-password-input"]').type('someUsername')
    })
    it('THEN I should see an error message', () => {
      cy.get('[data-cy="recover-password-button"]').click()
      cy.wait('@recoverPasswordRoute').then(() => {
        cy.get('[data-cy="snackbar-message"]').should('exist')
        cy.get('[data-cy="snackbar-message"]').contains('Error inesperado')
      })
    })
  })
  context('WHEN there I enter existant user', () => {
    beforeEach(() => {
      cy.intercept(routes.back + '/api/user/reset-password', (req) => {
        req.reply({
          statusCode: 200,
          body: { message: 'OK' },
          delay: 500
        })
      }).as('recoverPasswordRoute')
      cy.get('[data-cy="recover-password-input"]').type('existantUser')
    })
    it('THEN I should see a success message AND redirected to login page', () => {
      cy.get('[data-cy="recover-password-button"]').click()
      cy.wait('@recoverPasswordRoute').then(() => {
        cy.get('[data-cy="snackbar-message"]').should('exist')
        cy.get('[data-cy="snackbar-message"]').parent().parent().should('have.class', 'bg-success')
        cy.location('pathname').should('match', /\/login/)
      })
    })
  })
})
