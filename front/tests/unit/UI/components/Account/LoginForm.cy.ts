import { mount } from '@cypress/vue'
import LoginForm from '@/UI/components/Account/LoginForm.vue'

describe('Testing LoginForm Component', () => {
  it('Should render login button', () => {
    mount(LoginForm);
    cy.get('.v-btn').contains('Login');
  })
})
