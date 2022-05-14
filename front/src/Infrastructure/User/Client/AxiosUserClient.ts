import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { UserClient } from '@/Domain/User/UserClient'
import { UserClientError } from '@/Domain/User/UserClientError'
import { User } from '@/Domain/User/User'
import axios from 'axios'

interface AxiosUserResponse {
  token: string;
  refresh_token: string;
}
interface AxiosLoginData {
  username: string;
  password: string;
}
interface AxiosTokenData {
  refresh_token: string;
}
const baseApiUrl = import.meta.env.VITE_API_URL

export class AxiosUserClient implements UserClient{
  async login(name: Username, pass: Userpassword): Promise<User> {
    const baseUrl = baseApiUrl + '/api/login';
    const data = {
      'username': name.value(),
      'password': pass.value()
    }
    return this.makeAxiosPost(baseUrl, data)
  }
  async refresh(token: string): Promise<User> {
    const baseUrl = baseApiUrl + '/api/token/refresh'
    const data = { refresh_token: token }
    return this.makeAxiosPost(baseUrl, data)
  }

  private async makeAxiosPost(url: string, data: AxiosLoginData|AxiosTokenData): Promise<User> {
    try {
      const response = await axios.post<AxiosUserResponse>(url, data)
      return User.fromTokens(response.data.token, response.data.refresh_token)
    } catch (err) {
      if (err instanceof Error) {
        throw new UserClientError(err.message)
      }
      throw new Error('Undefined error: ' + <string> err)
    }
  }
}
