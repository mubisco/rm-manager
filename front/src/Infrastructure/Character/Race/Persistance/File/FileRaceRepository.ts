import { Culture } from '@/Domain/Character/Profession/Race/Culture'
import { RaceCode } from '@/Domain/Character/Profession/Race/RaceCode'
import { RaceDto } from '@/Domain/Character/Profession/Race/RaceDto'
import { RaceName } from '@/Domain/Character/Profession/Race/RaceName'
import { RaceNotFoundError } from '@/Domain/Character/Profession/Race/RaceNotFoundError'
import { RaceRepository } from '@/Domain/Character/Profession/Race/RaceRepository'
import { RacialStatsModifiers } from '@/Domain/Character/Profession/Race/RacialStatsModifiers'
import { ResistanceBonuses } from '@/Domain/Character/Profession/Race/ResistanceBonuses'
import racesData from './races.json'

export class FileRaceRepository implements RaceRepository {
  fetchNames (): Promise<RaceName[]> {
    const values = this.parseRaceNamesFromSource()
    return Promise.resolve(values)
  }

  ofCode (code: RaceCode): Promise<RaceDto> {
    // eslint-disable-next-line
    const filteredRaces = racesData.filter((rawData: any) => rawData.code === code)
    if (filteredRaces.length === 0) {
      return Promise.reject(new RaceNotFoundError(`Race of code ${code} not found!!!`))
    }
    const race = this.parseRaceData(filteredRaces[0])
    return Promise.resolve(race)
  }

  // eslint-disable-next-line
  private parseRaceData (raceData: any): RaceDto {
    const baseData = {
      code: raceData.code as RaceCode,
      name: raceData.name,
      racialStatsModifiers: raceData.racialStatsModifiers as RacialStatsModifiers,
      endurance: raceData.endurance,
      powerPoints: raceData.powerPoints,
      resistanceBonuses: raceData.resistanceBonuses as ResistanceBonuses,
      demeanor: raceData.demeanor,
      appearance: raceData.appearance,
      lifespan: raceData.lifespan,
      culture: raceData.culture,
      defaultCultures: raceData.defaultCultures as Culture[],
      specialAbilities: raceData.specialAbilities,
      selectableAbilities: null
    }
    if (raceData.selectableAbilities) {
      baseData.selectableAbilities = raceData.selectableAbilities
    }
    return baseData
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
