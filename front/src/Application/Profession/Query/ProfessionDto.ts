import { ProfessionCode } from '@/Domain/Character/Profession/ProfessionCode'
import { FreeCategory } from './FreeCategory'

export type ProfessionDto = {
  code: ProfessionCode,
  name: string
  description: string
  keyStats: string[]
  fixedCategories: { [key: string]: number }
  freeCategories: FreeCategory
  professionalAbilities: string[]
  notes: string[]
}
