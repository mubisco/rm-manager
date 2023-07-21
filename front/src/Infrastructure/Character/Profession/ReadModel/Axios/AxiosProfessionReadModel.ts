import { ProfessionName } from '@/Application/Profession/Query/ProfessionName'
import { ProfessionNameReadModel } from '@/Application/Profession/Query/ProfessionNameReadModel'
import { ProfessionNameReadModelError } from '@/Application/Profession/Query/ProfessionNameReadModelError'
import { UserRepository } from '@/Domain/User/UserRepository'
import axios, { AxiosError, AxiosRequestConfig } from 'axios'

const baseApiUrl = import.meta.env.VITE_API_URL

export class AxiosProfessionReadModel implements ProfessionNameReadModel {
  private _userRepository: UserRepository

  constructor (userRepository: UserRepository) {
    this._userRepository = userRepository
  }

  async fetchNames (): Promise<ProfessionName[]> {
    try {
      const config = await this.getConfig()
      const response = await axios.get<ProfessionName[]>(
        baseApiUrl + '/api/es/character/profession/names',
        config
      )
      return Promise.resolve(response.data)
    } catch (err: unknown) {
      const error = err as AxiosError
      throw new ProfessionNameReadModelError(error.message)
    }
  }

  private async getConfig (): Promise<AxiosRequestConfig> {
    const user = await this._userRepository.get()
    return {
      headers: { Authorization: 'Bearer ' + user.token() }
    }
  }
}
