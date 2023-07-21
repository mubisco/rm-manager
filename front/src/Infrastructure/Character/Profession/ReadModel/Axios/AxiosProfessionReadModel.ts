import { ProfessionName } from '@/Application/Profession/Query/ProfessionName'
import { ProfessionNameReadModel } from '@/Application/Profession/Query/ProfessionNameReadModel'
import { ProfessionNameReadModelError } from '@/Application/Profession/Query/ProfessionNameReadModelError'
import axios, { AxiosError } from 'axios'

const baseApiUrl = import.meta.env.VITE_API_URL

export class AxiosProfessionReadModel implements ProfessionNameReadModel {
  async fetchNames (): Promise<ProfessionName[]> {
    try {
      const response = await axios.get(baseApiUrl + '/api/es/character/profession/names')
      return Promise.resolve(response)
    } catch (err: unknown) {
      const error = err as AxiosError
      throw new ProfessionNameReadModelError(error.message)
    }
  }
}
