import { FetchCultureByCodeQuery } from '@/Application/Culture/Query/FetchCultureByCodeQuery'
import { FetchCultureByCodeQueryHandler } from '@/Application/Culture/Query/FetchCultureByCodeQueryHandler'
import { CultureNotFoundError } from '@/Domain/Character/Culture/CultureNotFoundError'
import { beforeEach, vi, describe, test, expect } from 'vitest'

const mockedRepository = {
  fetchNames: vi.fn(),
  ofCode: vi.fn()
}

describe('Testing FetchCultureByCodeQueryHandler', () => {
  let sut: FetchCultureByCodeQueryHandler

  beforeEach(() => {
    sut = new FetchCultureByCodeQueryHandler(mockedRepository)
  })
  test('It should be of proper class', () => {
    expect(sut).toBeInstanceOf(FetchCultureByCodeQueryHandler)
  })
  test('It should throw error when code not valid', () => {
    expect(sut.handle(new FetchCultureByCodeQuery('asd'))).rejects.toThrow(TypeError)
  })
  test('It should throw error when race with code does not exists', () => {
    mockedRepository.ofCode.mockRejectedValue(new CultureNotFoundError('Async test error'))
    expect(sut.handle(new FetchCultureByCodeQuery('DEEP_WARRENS'))).rejects.toThrow(CultureNotFoundError)
  })
  test('It should return proper Dto', async () => {
    const fakeDto = {
      code: 'SYLVAN',
      name: 'Silvana',
      description: 'Description',
      preferredLocations: 'Locations',
      clothingDecoration: 'Decoration',
      demeanor: 'Demeanor',
      startingLanguages: {
        COMMON: { spoken: 6, written: 3 },
        RACIAL: { spoken: 6, written: 3 }
      },
      skills: {
        acting: 1,
        climbing: 2
      }
    }
    mockedRepository.ofCode.mockResolvedValue(fakeDto)
    const result = await sut.handle(new FetchCultureByCodeQuery('DEEP_WARRENS'))
    expect(result.code).not.toBeUndefined()
    expect(result.name).not.toBeUndefined()
    expect(result.description).not.toBeUndefined()
    expect(result.preferredLocations).not.toBeUndefined()
    expect(result.clothingDecoration).not.toBeUndefined()
    expect(result.demeanor).not.toBeUndefined()
    expect(result.startingLanguages).not.toBeUndefined()
    expect(result.skills).not.toBeUndefined()
  })
})
