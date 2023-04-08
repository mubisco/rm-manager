import { StatCode } from '@/Domain/Character/StatCode'

export type RacialStatsModifiers = {
  [key in StatCode]: number | string
}
