/// <reference types="cypress" />
import tokens from '../../fixtures/tokens.json'
import routes from '../../fixtures/routes.json'

const prepareRefreshTokenResponse = (): void => {
  const backRoute = routes.back + '/api/token/refresh'
  cy.intercept(backRoute, (req) => {
    req.reply({
      statusCode: 200,
      body: {token: tokens.admin, refresh_token: 'anotherToken' },
    })
  }).as('refreshTokenRoute');
}
const prepareRefreshTokenResponseWithError = (): void => {
  const backRoute = routes.back + '/api/token/refresh'
  cy.intercept(backRoute, (req) => {
    req.reply({
      statusCode: 401,
      body: { message: 'asd' },
    })
  }).as('refreshTokenRouteWithError');
}
describe('GIVEN a unauthenticated user', () => {
  context('WHEN navigates to login page with a valid token', () => {
    beforeEach(() => {
      prepareRefreshTokenResponse()
      cy.visit(routes.front + '/login', {
        onBeforeLoad: (window): void => {
          window.localStorage.setItem('refreshToken', 'aVeryLargeToken')
        }
      })
    })
    it('THEN should login and navigate to dashboard page', () => {
      cy.wait('@refreshTokenRoute').then(() => {
        cy.location('pathname').should('match', /\/dashboard/);
      })
    })
    it('AND THEN user data should be on localStorage', () => {
      cy.wait('@refreshTokenRoute').then(() => {
        const rawUserData = localStorage.getItem('userData')
        const userData = rawUserData ? JSON.parse(rawUserData) : {}
        expect(userData?.role).to.be.eq('ADMIN')
        expect(userData?.username).to.be.eq('mubisco')
        expect(userData?.token).to.be.eq(tokens.admin)
      })
    })
    it('AND THEN new refresh token should be updated', () => {
      cy.wait(100).then(() => {
        const refreshToken = window.localStorage.getItem('refreshToken')
        expect(refreshToken).to.be.eq('anotherToken')
      })
    })
  })
  context('WHEN navigates to login page with an invalid token', () => {
    beforeEach(() => {
      prepareRefreshTokenResponseWithError()
      cy.visit(routes.front + '/login', {
        onBeforeLoad: (window): void => {
          window.localStorage.setItem('refreshToken', 'anInvalidToken')
        }
      })
    })
    it('THEN should stay on login page', () => {
      cy.wait('@refreshTokenRouteWithError').then(() => {
        cy.location('pathname').should('match', /\/login/);
      })
    })
    it('AND THEN user data should not be on localStorage', () => {
      cy.wait('@refreshTokenRouteWithError').then(() => {
        const rawUserData = localStorage.getItem('userData')
        expect(rawUserData).to.be.null
      })
    })
    it('AND THEN refresh token should not be stored', () => {
      cy.wait(100).then(() => {
        const refreshToken = localStorage.getItem('refreshToken')
        expect(refreshToken).to.be.null
      })
    })
  })
  context('WHEN navigates to login page with no previous refreshToken', () => {
    beforeEach(() => {
      prepareRefreshTokenResponse()
      cy.visit(routes.front + '/login')
    })
    it('THEN should stay on login page', () => {
      cy.location('pathname').should('match', /\/login/);
    })
  })
})
