import { DiceBag } from '@/Domain/DiceBag/DiceBag'
import { describe, test, expect } from 'vitest'

describe('Testing DiceBag', () => {
  test('Should be of proper class', () => {
    const sut = DiceBag.fromString('1D100+10')
    expect(sut).toBeInstanceOf(DiceBag)
  })
  test('It should throw error if string has wrong format', () => {
    expect(() => {
      DiceBag.fromString('100+10')
    }).toThrow(RangeError)
  })
  test('It should return proper string value', () => {
    const oneSut = DiceBag.fromString('D100+10')
    expect(oneSut.toString()).toBe('1d100+10')
    const anotherSut = DiceBag.fromString('D100')
    expect(anotherSut.toString()).toBe('1d100')
    const thirdSut = DiceBag.fromString('D100-50')
    expect(thirdSut.toString()).toBe('1d100-50')
    const fourthSut = DiceBag.fromString('5D10+5')
    expect(fourthSut.toString()).toBe('5d10+5')
  })
  test('It should return proper RollResultDto', () => {
    const oneSut = DiceBag.fromString('10D10-10')
    const result = oneSut.roll()
    expect(result.total).not.toBeNull()
    expect(result.rollBreakdown.length).toBe(10)
    expect(result.modifier).toBe(-10)
  })
  test('It should return proper Result when lower Treshold defined', () => {
    const oneSut = DiceBag.withTreshold('10D6', 5)
    const result = oneSut.roll()
    const breakdowns = result.rollBreakdown
    for (let i = 0; i < 10; i++) {
      const currentRoll = breakdowns[i]
      expect(currentRoll).toBeGreaterThanOrEqual(5)
    }
  })
})
