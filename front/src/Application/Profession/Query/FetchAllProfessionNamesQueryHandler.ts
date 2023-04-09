import { ProfessionName } from './ProfessionName'
import { ProfessionNameReadModel } from './ProfessionNameReadModel'

export class FetchAllProfessionNamesQueryHandler {
  private _readModel: ProfessionNameReadModel

  constructor (readModel: ProfessionNameReadModel) {
    this._readModel = readModel
  }

  handle (): Promise<ProfessionName[]> {
    return this._readModel.fetchNames()
  }
}
