
/// <reference types="cypress" />
import routes from '../../fixtures/routes.json'

// When loads i should see a loader
// If token does not exists I should get a 404 error
// If token has more than expiration time I should see a 400 error
// If token exists I should see the reset password form
//  Input for new password
//  Input for repeat password
//  Send button disabled
// If I fill the fields with wrong password I should see an error
// If I fill the fields properly the Submit button should be enabled
// If I push the button and there is an error I should see the message
// If I push the button and everything goes well I should see the confirm message
//  And I should be redirected to login page

describe('GIVEN a reset password page', () => {
  before(() => {
    cy.visit(routes.front + '/reset-password/a-very-large-token')
  })
  context('WHEN I navigate to', () => {
    it('THEN I should see a loader while checking token', () => {
      cy.get('[data-cy="reset-password-loader"]').should('exist');
    })
  })
})
