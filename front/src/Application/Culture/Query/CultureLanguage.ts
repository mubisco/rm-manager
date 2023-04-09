import { CultureLanguageCode } from './CultureLanguageCode'

export type CultureLanguage = {
  [key in CultureLanguageCode]: {
    spoken: number,
    written: number
  }
}
