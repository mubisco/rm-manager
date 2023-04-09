import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { CultureDto } from './CultureDto'
import { CultureReadModel } from './CultureReadModel'
import { FetchCultureByCodeQuery } from './FetchCultureByCodeQuery'

export class FetchCultureByCodeQueryHandler {
  private _readModel: CultureReadModel

  constructor (readModel: CultureReadModel) {
    this._readModel = readModel
  }

  handle (query: FetchCultureByCodeQuery): Promise<CultureDto> {
    if (!Object.values(CultureCode).includes(query.cultureCode as CultureCode)) {
      return Promise.reject(new TypeError('Value provided por CultureCode not valid!!'))
    }
    return this._readModel.ofCode(query.cultureCode as CultureCode)
  }
}
