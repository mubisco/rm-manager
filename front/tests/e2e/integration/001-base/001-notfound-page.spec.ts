/// <reference types="cypress" />

import routes from '../../fixtures/routes.json'

describe('GIVEN a non existant route', () => {
  context('WHEN I try to access to that route', () => {
    before(() => {
      cy.visit(routes.front + '/asdf-asdf')
    })
    it('THEN I should see 404 page', () => {
      cy.get('[data-cy="page-not-found"]').should('exist')
    })
  })
})
