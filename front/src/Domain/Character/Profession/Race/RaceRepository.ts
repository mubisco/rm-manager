import { RaceName } from './RaceName'

export interface RaceRepository {
  fetchNames(): Promise<RaceName[]>
}
