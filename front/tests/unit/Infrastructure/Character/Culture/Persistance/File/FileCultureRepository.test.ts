import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { FileCultureRepository } from '@/Infrastructure/Character/Culture/Persistance/File/FileCultureRepository'
import { describe, test, expect } from 'vitest'

describe('Testing FileCultureRepository', () => {
  test('It should be of proper class', () => {
    const sut = new FileCultureRepository()
    expect(sut).toBeInstanceOf(FileCultureRepository)
  })
  test('Should return proper CultureNames', async () => {
    const sut = new FileCultureRepository()
    const result = await sut.fetchNames()
    expect(result.length).toBe(7)
    expect(result[0].code).toBe('UNDERHILL')
    expect(result[0].name).toBe('Bajo las Colinas')
    expect(result[1].code).toBe('SHALLOW_WARRENS')
    expect(result[1].name).toBe('Cavernas en Superficie')
    expect(result[2].code).toBe('DEEP_WARRENS')
    expect(result[2].name).toBe('Cavernas Profundas')
    expect(result[3].code).toBe('NOMADIC')
    expect(result[3].name).toBe('Nómada')
    expect(result[4].code).toBe('RURAL')
    expect(result[4].name).toBe('Rural')
    expect(result[5].code).toBe('SYLVAN')
    expect(result[5].name).toBe('Silvana')
    expect(result[6].code).toBe('URBAN')
    expect(result[6].name).toBe('Urbana')
  })
  test('Should return proper race', async () => {
    const sut = new FileCultureRepository()
    const result = await sut.ofCode(CultureCode.SYLVAN)
    expect(result.code).toBe('SYLVAN')
  })
})
