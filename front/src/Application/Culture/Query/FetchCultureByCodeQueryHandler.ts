import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { CultureDto } from '@/Domain/Character/Culture/CultureDto'
import { FetchCultureByCodeQuery } from './FetchCultureByCodeQuery'
import { CultureRepository } from '@/Domain/Character/Culture/CultureRepository'

export class FetchCultureByCodeQueryHandler {
  private _repository: CultureRepository

  constructor (repository: CultureRepository) {
    this._repository = repository
  }

  handle (query: FetchCultureByCodeQuery): Promise<CultureDto> {
    if (!Object.values(CultureCode).includes(query.cultureCode as CultureCode)) {
      return Promise.reject(new TypeError('Value provided por CultureCode not valid!!'))
    }
    return this._repository.ofCode(query.cultureCode as CultureCode)
  }
}
