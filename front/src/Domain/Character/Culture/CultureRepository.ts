import { CultureName } from './CultureName'
import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { CultureDto } from './CultureDto'

export interface CultureRepository {
  fetchNames(): Promise<CultureName[]>
  ofCode(code: CultureCode): Promise<CultureDto>
}
