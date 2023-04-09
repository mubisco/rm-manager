import { CultureCode } from './CultureCode'
import { CultureLanguage } from './CultureLanguage'
import { CultureSkillSet } from './CultureSkillSet'

export type CultureDto = {
  code: CultureCode,
  name: string,
  description: string,
  preferredLocations: string,
  clothingDecoration: string,
  demeanor: string,
  startingLanguages: CultureLanguage,
  skills: CultureSkillSet
}
