import { RaceName } from './RaceName'

export interface RaceNameReadModel {
  fetchNames(): Promise<RaceName[]>
}
