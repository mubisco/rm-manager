import { FetchAllProfessionNamesQueryHandler } from '@/Application/Profession/Query/FetchAllProfessionNamesQueryHandler'
import { ProfessionNameReadModelError } from '@/Application/Profession/Query/ProfessionNameReadModelError'
import { beforeEach, describe, vi, test, expect } from 'vitest'

const mockedReadModel = {
  fetchNames: vi.fn()
}

describe('Testing FetchAllProfessionNamesQueryHandler', () => {
  let sut: FetchAllProfessionNamesQueryHandler

  beforeEach(() => {
    sut = new FetchAllProfessionNamesQueryHandler(mockedReadModel)
  })
  test('It should be of proper class', () => {
    expect(sut).toBeInstanceOf(FetchAllProfessionNamesQueryHandler)
  })
  test('It should throw error when quey fails', () => {
    mockedReadModel.fetchNames.mockRejectedValue(new ProfessionNameReadModelError('Async test error'))
    expect(sut.handle()).rejects.toThrow(ProfessionNameReadModelError)
  })
  test('It should return proper CultureNames', async () => {
    const expectedResponse = [
      { name: 'Clérigo', code: 'cleric' },
      { name: 'Mago', code: 'fighter' },
      { name: 'Arpista', code: 'harper' }
    ]
    mockedReadModel.fetchNames.mockResolvedValue(expectedResponse)
    const result = await sut.handle()
    expect(result.length).toBe(3)
  })
})
