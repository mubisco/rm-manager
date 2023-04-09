import { FetchAllCultureNamesQueryHandler } from '@/Application/Culture/Query/FetchAllCultureNamesQuery'
import { CultureRepositoryError } from '@/Domain/Character/Culture/CultureRepositoryError'
import { beforeEach, describe, vi, test, expect } from 'vitest'

const mockedRepository = {
  fetchNames: vi.fn(),
  ofCode: vi.fn()
}

describe('Testing FetchAllCultureNamesQueryHandler', () => {
  let sut: FetchAllCultureNamesQueryHandler

  beforeEach(() => {
    sut = new FetchAllCultureNamesQueryHandler(mockedRepository)
  })
  test('It should be of proper class', () => {
    expect(sut).toBeInstanceOf(FetchAllCultureNamesQueryHandler)
  })

  test('It should throw error when quey fails', () => {
    mockedRepository.fetchNames.mockRejectedValue(new CultureRepositoryError('Async test error'))
    expect(sut.handle()).rejects.toThrow(CultureRepositoryError)
  })
  test('It should return proper CultureNames', async () => {
    const expectedResponse = [
      { name: 'Cavernas Profundas', code: 'DEEP_WARRENS' },
      { name: 'Silvana', code: 'SYLVAN' },
      { name: 'Urbana', code: 'URBAN' }
    ]
    mockedRepository.fetchNames.mockResolvedValue(expectedResponse)
    const result = await sut.handle()
    expect(result.length).toBe(3)
  })
})
