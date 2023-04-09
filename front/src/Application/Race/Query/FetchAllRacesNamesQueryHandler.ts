import { RaceName } from './RaceName'
import { RaceNameReadModel } from './RaceNamesReadModel'

export class FetchAllRacesNamesQueryHandler {
  private _readModel: RaceNameReadModel

  constructor (readModel: RaceNameReadModel) {
    this._readModel = readModel
  }

  async handle (): Promise<RaceName[]> {
    return this._readModel.fetchNames()
  }
}
