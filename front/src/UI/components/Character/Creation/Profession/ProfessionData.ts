import { Stat } from './Stat'
import { FreeCategory } from './FreeCategory'

export interface ProfessionData {
  name: string
  description: string
  keyStats: Stat[]
  fixedCategories: { [key: string]: number }
  freeCategories: FreeCategory
  professionalAbilities: string[]
  notes: string[]
}
