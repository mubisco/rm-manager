import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { CultureDto } from './CultureDto'

export interface CultureReadModel {
  ofCode (code: CultureCode): Promise<CultureDto>
}
