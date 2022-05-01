import { defineStore } from 'pinia'

const parseRole = (role: string): string => {
  return role.replace('ROLE_', '');
}
const parseJwt = (token: string): { username: string, role: string } => {
  const parsedData = JSON.parse(atob(token.split('.')[1]));
  const username = parsedData ? parsedData.username : '';
  const roles: string[] = parsedData ? parsedData.roles : [];
  if (roles.length === 0) {
    return { username, role: '' }
  }
  if (roles.length === 1) {
    return { username, role: parseRole(roles[0]) }
  }
  const role = roles.filter((current: string) => {
    return current !== 'ROLE_USER'
  })
  return { username, role: parseRole(role[0]) }
};
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
      if (response.status === 200) {
        const parsedResponse = await response.json();
        localStorage.setItem('token', parsedResponse.token)
        localStorage.setItem('userData', JSON.stringify(parseJwt(parsedResponse.token)))
      }
      return response.status === 200
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
