import { CultureName } from './CultureName'
import { CultureNameReadModel } from './CultureNameReadModel'

export class FetchAllCultureNamesQueryHandler {
  private _readModel: CultureNameReadModel

  constructor (readModel: CultureNameReadModel) {
    this._readModel = readModel
  }

  handle (): Promise<CultureName[]> {
    return this._readModel.fetchNames()
  }
}
