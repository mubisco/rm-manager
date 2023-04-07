import { RaceCode } from '@/Domain/Character/Profession/Race/RaceCode'
import { RaceName } from '@/Domain/Character/Profession/Race/RaceName'
import { RaceRepository } from '@/Domain/Character/Profession/Race/RaceRepository'
import racesData from './races.json'

export class FileRaceRepository implements RaceRepository {
  fetchNames (): Promise<RaceName[]> {
    const values = this.parseRaceNamesFromSource()
    return Promise.resolve(values)
  }

  private parseRaceNamesFromSource (): RaceName[] {
    // eslint-disable-next-line
    const racesNames = racesData.map((rawData: any) => {
      return { code: rawData.code as RaceCode, name: rawData.name }
    })
    return racesNames.sort((a: RaceName, b: RaceName) => {
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
