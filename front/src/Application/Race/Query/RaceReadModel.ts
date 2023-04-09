import { RaceCode } from '@/Domain/Character/Race/RaceCode'
import { RaceDto } from './RaceDto'

export interface RaceReadModel {
  ofCode(code: RaceCode): Promise<RaceDto>
}
