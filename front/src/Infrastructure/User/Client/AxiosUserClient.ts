import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
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
      return User.fromToken(response.data.token)
    } catch (err) {
      if (err instanceof Error) {
        throw new UserClientError(err.message)
      }
      throw new Error('Undefined error: ' + <string> err)
    }
  }
}
