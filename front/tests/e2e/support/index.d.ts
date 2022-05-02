/// <reference types="cypress" />

declare namespace Cypress {
  interface Chainable {
    /**
     * Custom command to ... add your description here
     * @example cy.clickOnMyJourneyInCandidateCabinet()
     */
    customLogin: (email: string, password: string) => void
  }
}
