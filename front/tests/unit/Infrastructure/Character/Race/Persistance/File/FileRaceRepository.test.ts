import { FileRaceRepository } from '@/Infrastructure/Character/Race/Persistance/File/FileRaceRepository'
import { describe, test, expect } from 'vitest'

describe('Testing FileRaceRepository', () => {
  test('Should be of proper class', () => {
    const sut = new FileRaceRepository()
    expect(sut).toBeInstanceOf(FileRaceRepository)
  })
  test('Should return proper RaceNames', async () => {
    const sut = new FileRaceRepository()
    const result = await sut.fetchNames()
    expect(result.length).toBe(6)
    expect(result[0].code).toBe('ELF')
    expect(result[0].name).toBe('Elfo')
    expect(result[1].code).toBe('DWARF')
    expect(result[1].name).toBe('Enano')
    expect(result[2].code).toBe('GNOME')
    expect(result[2].name).toBe('Gnomo')
    expect(result[3].code).toBe('GRYX')
    expect(result[3].name).toBe('Gryx')
    expect(result[4].code).toBe('HALFLING')
    expect(result[4].name).toBe('Halfling')
    expect(result[5].code).toBe('HUMAN')
    expect(result[5].name).toBe('Humano')
  })
})
