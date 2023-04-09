import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { CultureName } from '@/Domain/Character/Culture/CultureName'
import { CultureNotFoundError } from '@/Domain/Character/Culture/CultureNotFoundError'
import { CultureRepository } from '@/Domain/Character/Culture/CultureRepository'
import { CultureDto } from '@/Domain/Character/CultureCultureDto'
import cultureData from './cultures.json'

export class FileCultureRepository implements CultureRepository {
  fetchNames (): Promise<CultureName[]> {
    const values = this.parseCultureNamesFromSource()
    return Promise.resolve(values)
  }

  ofCode (code: CultureCode): Promise<CultureDto> {
    // eslint-disable-next-line
    const filteredRaces = cultureData.filter((rawData: any) => rawData.code === code)
    if (filteredRaces.length === 0) {
      return Promise.reject(new CultureNotFoundError(`Culture with code ${code} not found!!!`))
    }
    const race = this.parseCultureData(filteredRaces[0])
    return Promise.resolve(race)
  }
  //
  // eslint-disable-next-line
  private parseCultureData (data: any): CultureDto {
    return {
      code: data.code as CultureCode,
      name: data.name,
      description: data.description,
      preferredLocations: data['preferred-locations'],
      clothingDecoration: data['clothing-decoration'],
      demeanor: data.demeanor,
      startingLanguages: data['starting-languages'],
      skills: data.skills
    }
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
