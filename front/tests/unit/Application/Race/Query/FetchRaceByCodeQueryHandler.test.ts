import { beforeEach, vi, describe, test, expect } from 'vitest'
import { FetchRaceByCodeQueryHandler } from '@/Application/Race/Query/FetchRaceByCodeQueryHandler'
import { FetchRaceByCodeQuery } from '@/Application/Race/Query/FetchRaceByCodeQuery'
import { RaceCode } from '@/Domain/Character/Race/RaceCode'
import { RaceNotFoundError } from '@/Application/Race/Query/RaceNotFoundError'

const mockedReadModel = {
  fetchNames: vi.fn(),
  ofCode: vi.fn()
}

describe('Testing FetchRaceByCodeQueryHandler', () => {
  let sut: FetchRaceByCodeQueryHandler

  beforeEach(() => {
    sut = new FetchRaceByCodeQueryHandler(mockedReadModel)
  })
  test('It should be of proper class', () => {
    expect(sut).toBeInstanceOf(FetchRaceByCodeQueryHandler)
  })
  test('It should throw error when code not valid', () => {
    expect(sut.handle(new FetchRaceByCodeQuery('asd'))).rejects.toThrow(TypeError)
  })
  test('It should throw error when race with code does not exists', () => {
    mockedReadModel.ofCode.mockRejectedValue(new RaceNotFoundError('Async test error'))
    expect(sut.handle(new FetchRaceByCodeQuery('ELF'))).rejects.toThrow(RaceNotFoundError)
  })
  test('It should return proper Dto', async () => {
    const fakeDto = {
      code: RaceCode.ELF,
      name: 'Elfo',
      racialStatsModifiers: {},
      endurance: 50,
      powerPoints: 12,
      resistanceBonuses: {},
      demeanor: 'asd',
      appearance: 'asd',
      lifespan: 'asd',
      culture: 'asd',
      defaultCultures: [],
      specialAbilities: {}
    }
    mockedReadModel.ofCode.mockResolvedValue(fakeDto)
    const result = await sut.handle(new FetchRaceByCodeQuery('ELF'))
    expect(result.code).not.toBeUndefined()
    expect(result.name).not.toBeUndefined()
    expect(result.racialStatsModifiers).not.toBeUndefined()
    expect(result.endurance).not.toBeUndefined()
    expect(result.powerPoints).not.toBeUndefined()
    expect(result.resistanceBonuses).not.toBeUndefined()
    expect(result.demeanor).not.toBeUndefined()
    expect(result.appearance).not.toBeUndefined()
    expect(result.lifespan).not.toBeUndefined()
    expect(result.culture).not.toBeUndefined()
    expect(result.defaultCultures).not.toBeUndefined()
    expect(result.specialAbilities).not.toBeUndefined()
  })
})
