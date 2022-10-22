import { PasswordTokenRepository } from '@/Domain/User/PasswordToken/PassowrdTokenRepository'
import { PasswordTokenExpiredError } from '@/Domain/User/PasswordToken/PasswordTokenExpiredError'
import { PasswordTokenNotFoundError } from '@/Domain/User/PasswordToken/PasswordTokenNotFoundError'
import axios, { AxiosError } from 'axios'

const baseApiUrl = import.meta.env.VITE_API_URL

export class AxiosPasswordTokenClient implements PasswordTokenRepository {
  public async statusByToken (token: string): Promise<boolean> {
    const endpointUrl = baseApiUrl + '/api/account/check-token/' + token
    try {
      await axios.get(endpointUrl)
    } catch (e) {
      const error = e as AxiosError
      if (error.response?.status === 404) {
        throw new PasswordTokenNotFoundError(error.response?.data.error as string)
      }
      if (error.response?.status === 400) {
        throw new PasswordTokenExpiredError(error.response?.data.error as string)
      }
    }
    return true
  }
}
