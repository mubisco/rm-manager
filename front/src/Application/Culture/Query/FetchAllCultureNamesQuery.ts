import { CultureName } from '@/Domain/Character/Culture/CultureName'
import { CultureRepository } from '@/Domain/Character/Culture/CultureRepository'

export class FetchAllCultureNamesQueryHandler {
  private _repository: CultureRepository

  constructor (repository: CultureRepository) {
    this._repository = repository
  }

  handle (): Promise<CultureName[]> {
    return this._repository.fetchNames()
  }
}
