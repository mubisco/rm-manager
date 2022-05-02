import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { UserRole } from '@/Domain/User/UserRole'
import { UserClient } from '@/Domain/User/UserClient'
import { UserClientError } from '@/Domain/User/UserClientError'
import { User } from '@/Domain/User/User'
import axios from 'axios'

interface AxiosUserResponse {
  token: string;
}

export class AxiosUserClient implements UserClient{
  async login(name: Username, pass: Userpassword): Promise<User> {
    const baseUrl = import.meta.env.VITE_API_URL + '/api/login';
    const data = {
      'username': name.value(),
      'password': pass.value()
    }
    try {
      const response = await axios.post<AxiosUserResponse>(baseUrl, data)
      const parsedToken = this.parseJwt(response.data.token)
      return new User(new Username(parsedToken.username), UserRole[parsedToken.role])
    } catch (err) {
      throw new UserClientError(err.message)
    }
  }

  private parseJwt (token: string): { username: string, role: string } {
    const parsedData = JSON.parse(window.atob(token.split('.')[1]));
    const username = parsedData ? parsedData.username : '';
    const roles: string[] = parsedData ? parsedData.roles : [];
    if (roles.length === 0) {
      return { username, role: '' }
    }
    if (roles.length === 1) {
      return { username, role: this.parseRole(roles[0]) }
    }
    const role = roles.filter((current: string) => {
      return current !== 'ROLE_USER'
    })
    return { username, role: this.parseRole(role[0]) }
  }
  private parseRole(role: string): string {
    return role.replace('ROLE_', '');
  }
}
