/// <reference types="cypress" />
describe('Test Login page', () => {
  it('Should access login', () => {
    cy.visit('http://localhost:3000/login')
    cy.get('.v-card').get('.v-btn').contains('Login').should('be.disabled')
  })
});
