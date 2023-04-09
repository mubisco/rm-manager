import { RaceCode } from '@/Domain/Character/Race/RaceCode'
import type { RacialStatsModifiers } from './RacialStatsModifiers'
import type { ResistanceBonuses } from './ResistanceBonuses'
import type { SpecialAbilityDescription } from './SpecialAbilityDescription'

type SpecialAbilities = {
    [key: string]: SpecialAbilityDescription
}

export type RaceDto = {
  code: RaceCode,
  name: string,
  racialStatsModifiers: RacialStatsModifiers,
  endurance: number,
  powerPoints: number,
  resistanceBonuses: ResistanceBonuses,
  demeanor: string,
  appearance: string,
  lifespan: string,
  culture: string,
  defaultCultures: string[],
  specialAbilities: SpecialAbilities,
  selectableAbilities: SpecialAbilities | null
}
