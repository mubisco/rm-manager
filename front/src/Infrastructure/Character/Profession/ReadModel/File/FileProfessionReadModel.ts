import { ProfessionDto } from '@/Application/Profession/Query/ProfessionDto'
import { ProfessionName } from '@/Application/Profession/Query/ProfessionName'
import { ProfessionNameReadModel } from '@/Application/Profession/Query/ProfessionNameReadModel'
import { ProfessionNotFoundError } from '@/Application/Profession/Query/ProfessionNotFoundError'
import { ProfessionReadModel } from '@/Application/Profession/Query/ProfessionReadModel'
import { ProfessionCode } from '@/Domain/Character/Profession/ProfessionCode'
import professionsData from './professions.json'

export class FileProfessionReadModel implements ProfessionReadModel, ProfessionNameReadModel {
  ofCode (code: ProfessionCode): Promise<ProfessionDto> {
    // eslint-disable-next-line
    const filteredRaces = professionsData.filter((rawData: any) => rawData.code === code)
    if (filteredRaces.length === 0) {
      return Promise.reject(new ProfessionNotFoundError(`Profession with code ${code} not found!!!`))
    }
    const race = this.parseProfessionData(filteredRaces[0])
    return Promise.resolve(race)
  }

  // eslint-disable-next-line
  private parseProfessionData (professionData: any): ProfessionDto {
    return {
      code: professionData.code as ProfessionCode,
      name: professionData.name,
      description: professionData.description,
      keyStats: professionData.keyStats,
      fixedCategories: professionData.fixedCategories,
      freeCategories: professionData.freeCategories,
      professionalAbilities: professionData.professionalAbilities,
      notes: professionData.notes
    }
  }

  fetchNames (): Promise<ProfessionName[]> {
    return Promise.resolve(this.parseNamesFromSource())
  }

  private parseNamesFromSource (): ProfessionName[] {
    // eslint-disable-next-line
    const parsedNames = professionsData.map((rawData: any): ProfessionName => {
      return { code: rawData.code as ProfessionCode, name: rawData.name }
    })
    return parsedNames.sort((a: ProfessionName, b: ProfessionName) => {
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
