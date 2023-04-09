import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { CultureName } from '@/Domain/Character/Culture/CultureName'
import { CultureRepository } from '@/Domain/Character/Culture/CultureRepository'
import cultureData from './cultures.json'

export class FileCultureRepository implements CultureRepository {
  fetchNames (): Promise<CultureName[]> {
    const values = this.parseCultureNamesFromSource()
    return Promise.resolve(values)
  }

  private parseCultureNamesFromSource (): CultureName[] {
    // eslint-disable-next-line
    const racesNames = cultureData.map((rawData: any) => {
      return { code: rawData.code as CultureCode, name: rawData.name }
    })
    return racesNames.sort((a: CultureName, b: CultureName) => {
      const firstname = a.name.toLowerCase()
      const secondname = b.name.toLowerCase()
      if (firstname < secondname) {
        return -1
      }
      if (firstname > secondname) {
        return 1
      }
      return 0
    })
  }
}
