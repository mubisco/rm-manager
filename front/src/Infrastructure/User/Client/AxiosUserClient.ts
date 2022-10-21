import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { UserClient } from '@/Domain/User/UserClient'
import { UserClientError } from '@/Domain/User/UserClientError'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
import { User } from '@/Domain/User/User'
import axios, { AxiosError } from 'axios'

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
interface AxiosResetPasswordData {
  username: string;
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

  async resetPassword(name: Username): Promise<boolean> {
    const url = baseApiUrl + '/api/user/reset-password'
    const data = { username: name.value() }
    try {
      await axios.put<AxiosResetPasswordData>(url, data)
      return true
    } catch (err: unknown) {
      const error = err as AxiosError
      if (error.response?.status === 404) {
        throw new UserNotFoundError(error.message)
      }
      throw new UserClientError(error.message)
    }
  }
  async changePassword(password: Userpassword, token: string): Promise<boolean> {
    const baseUrl = baseApiUrl + '/api/account/reset-password';
    const data = {
      'token': token,
      'password': password.value()
    }
    try {
      await axios.post(baseUrl, data)
      return true
    } catch (err) {
      if (err instanceof Error) {
        throw new UserClientError(err.message)
      }
      throw new Error('Undefined error: ' + <string> err)
    }
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
