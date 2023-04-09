import { ProfessionCode } from '@/Domain/Character/Profession/ProfessionCode'
import { ProfessionDto } from './ProfessionDto'

export interface ProfessionReadModel {
  ofCode(code: ProfessionCode): Promise<ProfessionDto>
}
