import { RaceCode } from '@/Domain/Character/Profession/Race/RaceCode'
import { RaceDto } from '@/Domain/Character/Profession/Race/RaceDto'
import { RaceRepository } from '@/Domain/Character/Profession/Race/RaceRepository'
import { FetchRaceByCodeQuery } from './FetchRaceByCodeQuery'

export class FetchRaceByCodeQueryHandler {
  private _repository: RaceRepository

  constructor (repository: RaceRepository) {
    this._repository = repository
  }

  async handle (query: FetchRaceByCodeQuery): Promise<RaceDto> {
    if (!Object.values(RaceCode).includes(query.raceCode as RaceCode)) {
      return Promise.reject(new TypeError('Value provided por RaceCode not valid!!'))
    }
    return this._repository.ofCode(query.raceCode as RaceCode)
  }
}
