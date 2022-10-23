/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

const mockSuccessfulTokenCheck = () => {
  cy.intercept('GET', routes.back + '/api/user/check-password-token/a-very-large-token', {
    delay: 500,
    body: { message: 'NOT_AUTH' },
    statusCode: 200
  }).as('checkTokenUrl')
}
const fillPasswordProperly = () => {
  cy.get('[data-cy="new-password"]').type('onePassword')
  cy.get('[data-cy="confirm-new-password"]').type('onePassword')
}

describe('GIVEN a non registered user', () => {
  context('WHEN I navigate to reset password page', () => {
    beforeEach(() => {
      cy.visit(routes.front + '/reset-password/a-very-large-token')
    })
    it('THEN I should see a loader while checking token', () => {
      cy.get('[data-cy="reset-password-loader"]').should('exist')
    })
  })
  context('WHEN I navigate to with an non existing token', () => {
    before(() => {
      cy.intercept('GET', routes.back + '/api/user/check-password-token/a-very-large-token', {
        delay: 500,
        body: { message: 'NOT_AUTH' },
        statusCode: 404
      }).as('checkTokenUrl')
    })
    it('THEN I should see a error message', () => {
      cy.visit(routes.front + '/reset-password/a-very-large-token')
      cy.wait('@checkTokenUrl').then(() => {
        cy.get('[data-cy="token-error"]').should('exist')
      })
    })
  })
  context('WHEN I navigate to with a valid token', () => {
    it('THEN I should see reset password form', () => {
      mockSuccessfulTokenCheck()
      cy.visit(routes.front + '/reset-password/a-very-large-token')
      cy.wait('@checkTokenUrl').then(() => {
        cy.get('[data-cy="change-password-form"]').should('exist')
        cy.get('[data-cy="new-password"]').should('exist')
        cy.get('[data-cy="confirm-new-password"]').should('exist')
        cy.get('[data-cy="send-new-password"]').should('exist')
        cy.get('[data-cy="send-new-password"]').should('be.disabled')
      })
    })
  })
  context('WHEN I fill the two fields with different passwords', () => {
    it('THEN I should see and warning error and button should be disabled', () => {
      mockSuccessfulTokenCheck()
      cy.visit(routes.front + '/reset-password/a-very-large-token')
      cy.wait('@checkTokenUrl').then(() => {
        cy.get('[data-cy="new-password"]').type('onePassword')
        cy.get('[data-cy="confirm-new-password"]').type('anotherPassword')
        cy.get('[data-cy="confirm-new-password"]').should('have.class', 'v-input--error')
        cy.get('[data-cy="send-new-password"]').should('be.disabled')
      })
    })
  })
  context('WHEN I fill the two fields with same passwords', () => {
    it('THEN send button should be enabled', () => {
      mockSuccessfulTokenCheck()
      cy.visit(routes.front + '/reset-password/a-very-large-token')
      cy.wait('@checkTokenUrl').then(() => {
        fillPasswordProperly()
        cy.get('[data-cy="send-new-password"]').should('be.enabled')
      })
    })
  })
  context('AND WHEN there is an error sending password', () => {
    it('THEN send button should be enabled', () => {
      mockSuccessfulTokenCheck()
      cy.intercept('PATCH', routes.back + '/api/user/password/change', {
        delay: 500,
        body: { message: 'NOT_AUTH' },
        statusCode: 500
      }).as('changePasswordUrl')
      cy.visit(routes.front + '/reset-password/a-very-large-token')
      cy.wait('@checkTokenUrl').then(() => {
        fillPasswordProperly()
        cy.get('[data-cy="send-new-password"]').click()
        cy.wait('@changePasswordUrl').then(() => {
          cy.get('[data-cy="token-error"]').should('exist')
        })
      })
    })
  })
  context('AND WHEN password is reset', () => {
    it('THEN send button should be enabled', () => {
      mockSuccessfulTokenCheck()
      cy.intercept('PATCH', routes.back + '/api/user/password/change', {
        delay: 500,
        body: { message: 'NOT_AUTH' },
        statusCode: 200
      }).as('changePasswordUrl')
      cy.visit(routes.front + '/reset-password/a-very-large-token')
      cy.wait('@checkTokenUrl').then(() => {
        fillPasswordProperly()
        cy.get('[data-cy="send-new-password"]').click()
        // cy.get('[data-cy="token-success"]').should('exist');
        cy.location('pathname').should('match', /\/login/)
      })
    })
  })
})
