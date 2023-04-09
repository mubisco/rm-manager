import { ProfessionCode } from '@/Domain/Character/Profession/ProfessionCode'
import { FileProfessionReadModel } from '@/Infrastructure/Character/Profession/ReadModel/File/FileProfessionReadModel'
import { beforeEach, describe, test, expect } from 'vitest'

describe('Testing FileProfessionReadModel', () => {
  let sut: FileProfessionReadModel

  beforeEach(() => {
    sut = new FileProfessionReadModel()
  })

  test('It should be of proper class', () => {
    expect(sut).toBeInstanceOf(FileProfessionReadModel)
  })

  test('Should return proper Profession names', async () => {
    const result = await sut.fetchNames()
    expect(result.length).toBe(9)
    expect(result[0].code).toBe('rogue')
    expect(result[0].name).toBe('Bribón')
    expect(result[1].code).toBe('cleric')
    expect(result[1].name).toBe('Clérigo')
    expect(result[2].code).toBe('ranger')
    expect(result[2].name).toBe('Explorador')
    expect(result[3].code).toBe('harper')
    expect(result[3].name).toBe('Harpista')
    expect(result[4].code).toBe('thief')
    expect(result[4].name).toBe('Ladrón')
    expect(result[5].code).toBe('fighter')
    expect(result[5].name).toBe('Luchador')
    expect(result[6].code).toBe('mage')
    expect(result[6].name).toBe('Mago')
    expect(result[7].code).toBe('warriorMage')
    expect(result[7].name).toBe('Mago Guerrero')
    expect(result[8].code).toBe('monk')
    expect(result[8].name).toBe('Monje')
  })

  test('Should return proper profession', async () => {
    const result = await sut.ofCode(ProfessionCode.CLERIC)
    expect(result.code).toBe('cleric')
  })
})
