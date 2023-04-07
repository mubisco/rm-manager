import { RaceCode } from './RaceCode'
import { RaceDto } from './RaceDto'
import { RaceName } from './RaceName'

export interface RaceRepository {
  fetchNames(): Promise<RaceName[]>
  ofCode(code: RaceCode): Promise<RaceDto>
}
