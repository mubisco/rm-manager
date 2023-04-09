import { RaceDto } from '@/Application/Race/Query/RaceDto'
import { RaceName } from '@/Application/Race/Query/RaceName'
import { RaceNameReadModel } from '@/Application/Race/Query/RaceNamesReadModel'
import { RaceNotFoundError } from '@/Application/Race/Query/RaceNotFoundError'
import { RaceReadModel } from '@/Application/Race/Query/RaceReadModel'
import { RacialStatsModifiers } from '@/Application/Race/Query/RacialStatsModifiers'
import { ResistanceBonuses } from '@/Application/Race/Query/ResistanceBonuses'
import { RaceCode } from '@/Domain/Character/Race/RaceCode'
import racesData from './races.json'

export class FileRaceReadModel implements RaceReadModel, RaceNameReadModel {
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
      defaultCultures: raceData.defaultCultures,
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
