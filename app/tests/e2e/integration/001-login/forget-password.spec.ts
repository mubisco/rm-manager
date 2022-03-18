/// <reference types="cypress" />
describe('GIVEN a login page', () => {
  before(() => {
      cy.visit('http://localhost:3000/login')
  })
  context('WHEN I click on forgot password link', () => {
    before(() => {
      cy.get('[data-cy="login-forgot"]').click()
    })
    it('THEN navigate to forgot-password page', () => {
      cy.location('pathname').should('match', /\/forgot-password/);
    })
  })
})
