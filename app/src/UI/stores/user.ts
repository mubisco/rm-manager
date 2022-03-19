import { defineStore } from 'pinia'

export const useUsers = defineStore('users', {
  state: () => ({
    token: '',
    username: '',
    role: ''
  }),
  getters: {
  }, 
  actions: {
    async login(email: string, password: string): Promise<boolean> {
      const response = await fetch('/api/login', {
        method: 'POST',
        body: JSON.stringify({ email: email, pass: password })
      })
      if (response.status === 403) {
        return false
      }
      return true;
    },
    async refreshToken(): Promise<void> {
      const response = await fetch('/api/login/renew', {
        method: 'GET',
        headers: { 'Authorization': `Bearer ${this.token}` }
      })
      if (response.status !== 200) {
        this.token = ''
      }
      // const parsedReponse = await response.json();
    }
  }
})
