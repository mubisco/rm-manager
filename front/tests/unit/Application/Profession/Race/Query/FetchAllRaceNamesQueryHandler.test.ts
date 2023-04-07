import { FetchAllRacesNamesQueryHandler } from '@/Application/Profession/Race/Query/FetchAllRacesNamesQueryHandler'
import { RaceRepositoryError } from '@/Domain/Character/Profession/Race/RaceRepositoryError'
import { beforeEach, describe, vi, test, expect } from 'vitest'

const mockedRepository = {
  fetchNames: vi.fn(),
  ofCode: vi.fn()
}

describe('Testing FetchAllRacesNamesQueryHandler', () => {
  let sut: FetchAllRacesNamesQueryHandler

  beforeEach(() => {
    sut = new FetchAllRacesNamesQueryHandler(mockedRepository)
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(FetchAllRacesNamesQueryHandler)
  })
  test('It should throw error when query fails', () => {
    mockedRepository.fetchNames.mockRejectedValue(new RaceRepositoryError('Async test error'))
    expect(sut.handle()).rejects.toThrow(RaceRepositoryError)
  })
  test('It should return proper RaceNames', async () => {
    const expectedResponse = [
      { name: 'Gryx', code: 'GRYX' },
      { name: 'Enano', code: 'DWARF' },
      { name: 'Elfo', code: 'ELF' }
    ]
    mockedRepository.fetchNames.mockResolvedValue(expectedResponse)
    const result = await sut.handle()
    expect(result.length).toBe(3)
  })
})
