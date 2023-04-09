import { ProfessionCode } from '@/Domain/Character/Profession/ProfessionCode'
import { FetchProfessionByCodeQuery } from './FetchProfessionByCodeQuery'
import { ProfessionDto } from './ProfessionDto'
import { ProfessionReadModel } from './ProfessionReadModel'

export class FetchProfessionByCodeQueryHandler {
  private _readModel: ProfessionReadModel

  constructor (readModel: ProfessionReadModel) {
    this._readModel = readModel
  }

  handle (query: FetchProfessionByCodeQuery): Promise<ProfessionDto> {
    if (!Object.values(ProfessionCode).includes(query.professionCode as ProfessionCode)) {
      return Promise.reject(new TypeError('Value provided por CultureCode not valid!!'))
    }
    return this._readModel.ofCode(query.professionCode as ProfessionCode)
  }
}
