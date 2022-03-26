/// <reference types="cypress" />

import tokens from '../../fixtures/tokens.json'

const prepareLoginResponse = (expectedResponse: string): void => {
  cy.intercept('/api/login', (req) => {
    req.reply({
      statusCode: 200,
      body: {token: expectedResponse },
      delay: 500,
    })
  }).as('loginRoute');
}
describe('GIVEN a login page', () => {
  beforeEach(() => {
    cy.visit('http://localhost:3000/login')
  })
  context('WHEN I try to login as an Admin', () => {
    beforeEach(() => {
      prepareLoginResponse(tokens.admin)
    })
    it('THEN should navigate to admin dashboard page', () => {
      cy.customLogin('admin_user', 'holakease')
      cy.location('pathname').should('match', /\/dashboard/);
      cy.wait('@loginRoute').then(() => {
        const token = localStorage.getItem('token')
        expect(token).to.be.eq(tokens.admin)
        const rawUserData = localStorage.getItem('userData')
        const userData = rawUserData ? JSON.parse(rawUserData) : {}
        expect(userData?.role).to.be.eq('ADMIN')
        expect(userData?.username).to.be.eq('mubisco')
      })
    })
  })
  context('WHEN I try to login as a Master', () => {
    beforeEach(() => {
      prepareLoginResponse(tokens.master)
    })
    it('THEN should navigate to admin dashboard page', () => {
      cy.customLogin('master_user', 'holakease')
      cy.wait('@loginRoute').then(() => {
        const token = localStorage.getItem('token')
        expect(token).to.be.eq(tokens.master)
        const rawUserData = localStorage.getItem('userData')
        const userData = rawUserData ? JSON.parse(rawUserData) : {}
        expect(userData?.role).to.be.eq('MASTER')
        expect(userData?.username).to.be.eq('dungeon_master')
      })
      cy.location('pathname').should('match', /\/dashboard/);
    })
  })
  context('WHEN I try to login as Player', () => {
    beforeEach(() => {
      prepareLoginResponse(tokens.player)
    })
    it('THEN should navigate to admin dashboard page', () => {
      cy.customLogin('player_user', 'holakease')
      cy.wait('@loginRoute').then(() => {
        const token = localStorage.getItem('token')
        expect(token).to.be.eq(tokens.player)
        const rawUserData = localStorage.getItem('userData')
        const userData = rawUserData ? JSON.parse(rawUserData) : {}
        expect(userData?.role).to.be.eq('USER')
        expect(userData?.username).to.be.eq('mindundi')
      })
      cy.location('pathname').should('match', /\/dashboard/);
    })
  })
})
