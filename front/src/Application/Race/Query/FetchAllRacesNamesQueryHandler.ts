import { RaceName } from '@/Domain/Character/Race/RaceName'
import { RaceRepository } from '@/Domain/Character/Race/RaceRepository'

export class FetchAllRacesNamesQueryHandler {
  private _repository: RaceRepository

  constructor (repository: RaceRepository) {
    this._repository = repository
  }

  async handle (): Promise<RaceName[]> {
    return this._repository.fetchNames()
  }
}
