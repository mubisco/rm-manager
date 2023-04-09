import { FetchProfessionByCodeQuery } from '@/Application/Profession/Query/FetchProfessionByCodeQuery'
import { FetchProfessionByCodeQueryHandler } from '@/Application/Profession/Query/FetchProfessionByCodeQueryHandler'
import { ProfessionNotFoundError } from '@/Application/Profession/Query/ProfessionNotFoundError'
import { beforeEach, vi, describe, test, expect } from 'vitest'

const mockedReadModel = {
  ofCode: vi.fn()
}

describe('Testing FetchProfessionByCodeQueryHandler', () => {
  let sut: FetchProfessionByCodeQueryHandler

  beforeEach(() => {
    sut = new FetchProfessionByCodeQueryHandler(mockedReadModel)
  })
  test('It should be of proper class', () => {
    expect(sut).toBeInstanceOf(FetchProfessionByCodeQueryHandler)
  })
  test('It should throw error when code not valid', () => {
    expect(sut.handle(new FetchProfessionByCodeQuery('asd'))).rejects.toThrow(TypeError)
  })
  test('It should throw error when race with code does not exists', () => {
    mockedReadModel.ofCode.mockRejectedValue(new ProfessionNotFoundError('Async test error'))
    expect(sut.handle(new FetchProfessionByCodeQuery('cleric'))).rejects.toThrow(ProfessionNotFoundError)
  })
  test('It should return proper Dto', async () => {
    const fakeDto = {
      code: 'cleric',
      name: 'Clérigo',
      description: 'Description',
      keyStats: [],
      fixedCategories: {},
      freeCategories: {},
      professionalAbilities: ['asd', 'qwr'],
      notes: ['asd', 'qwr']
    }
    mockedReadModel.ofCode.mockResolvedValue(fakeDto)
    const result = await sut.handle(new FetchProfessionByCodeQuery('cleric'))
    expect(result).toBe(fakeDto)
  })
})
