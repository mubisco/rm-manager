import { RaceCode } from '@/Domain/Character/Race/RaceCode'
import { FetchRaceByCodeQuery } from './FetchRaceByCodeQuery'
import { RaceDto } from './RaceDto'
import { RaceReadModel } from './RaceReadModel'

export class FetchRaceByCodeQueryHandler {
  private _readModel: RaceReadModel

  constructor (readModel: RaceReadModel) {
    this._readModel = readModel
  }

  async handle (query: FetchRaceByCodeQuery): Promise<RaceDto> {
    if (!Object.values(RaceCode).includes(query.raceCode as RaceCode)) {
      return Promise.reject(new TypeError('Value provided por RaceCode not valid!!'))
    }
    return this._readModel.ofCode(query.raceCode as RaceCode)
  }
}
