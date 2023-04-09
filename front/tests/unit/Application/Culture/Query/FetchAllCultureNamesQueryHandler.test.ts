import { CultureNameReadModelError } from '@/Application/Culture/Query/CultureNameReadModelError'
import { FetchAllCultureNamesQueryHandler } from '@/Application/Culture/Query/FetchAllCultureNamesQueryHandler'
import { beforeEach, describe, vi, test, expect } from 'vitest'

const mockedReadModel = {
  fetchNames: vi.fn()
}

describe('Testing FetchAllCultureNamesQueryHandler', () => {
  let sut: FetchAllCultureNamesQueryHandler

  beforeEach(() => {
    sut = new FetchAllCultureNamesQueryHandler(mockedReadModel)
  })
  test('It should be of proper class', () => {
    expect(sut).toBeInstanceOf(FetchAllCultureNamesQueryHandler)
  })

  test('It should throw error when quey fails', () => {
    mockedReadModel.fetchNames.mockRejectedValue(new CultureNameReadModelError('Async test error'))
    expect(sut.handle()).rejects.toThrow(CultureNameReadModelError)
  })
  test('It should return proper CultureNames', async () => {
    const expectedResponse = [
      { name: 'Cavernas Profundas', code: 'DEEP_WARRENS' },
      { name: 'Silvana', code: 'SYLVAN' },
      { name: 'Urbana', code: 'URBAN' }
    ]
    mockedReadModel.fetchNames.mockResolvedValue(expectedResponse)
    const result = await sut.handle()
    expect(result.length).toBe(3)
  })
})
