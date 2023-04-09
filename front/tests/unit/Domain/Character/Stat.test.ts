import { Stat } from '@/Domain/Character/Stat/Stat'
import { StatCode } from '@/Domain/Character/Stat/StatCode'
import { StatOutOfBoundsError } from '@/Domain/Character/Stat/StatOutOfBoundsError'
import { StatValueError } from '@/Domain/Character/Stat/StatValueError'
import { describe, test, expect } from 'vitest'

const EQUIVALENCES = [
  { value: 0, spentPoints: 0, bonus: -20, developmentPoints: 0.25 },
  { value: 1, spentPoints: 1, bonus: -18, developmentPoints: 0.25 },
  { value: 5, spentPoints: 5, bonus: -18, developmentPoints: 0.25 },
  { value: 6, spentPoints: 6, bonus: -16, developmentPoints: 0.25 },
  { value: 10, spentPoints: 10, bonus: -16, developmentPoints: 0.25 },
  { value: 11, spentPoints: 11, bonus: -14, developmentPoints: 0.5 },
  { value: 16, spentPoints: 16, bonus: -12, developmentPoints: 0.5 },
  { value: 21, spentPoints: 21, bonus: -10, developmentPoints: 0.5 },
  { value: 26, spentPoints: 26, bonus: -8, developmentPoints: 0.5 },
  { value: 31, spentPoints: 31, bonus: -6, developmentPoints: 0.75 },
  { value: 36, spentPoints: 36, bonus: -4, developmentPoints: 0.75 },
  { value: 41, spentPoints: 41, bonus: -2, developmentPoints: 0.75 },
  { value: 46, spentPoints: 46, bonus: 0, developmentPoints: 0.75 },
  { value: 51, spentPoints: 51, bonus: 1, developmentPoints: 1 },
  { value: 56, spentPoints: 56, bonus: 2, developmentPoints: 2 },
  { value: 61, spentPoints: 61, bonus: 3, developmentPoints: 3 },
  { value: 66, spentPoints: 66, bonus: 4, developmentPoints: 4 },
  { value: 71, spentPoints: 71, bonus: 5, developmentPoints: 5 },
  { value: 76, spentPoints: 76, bonus: 6, developmentPoints: 6 },
  { value: 81, spentPoints: 81, bonus: 7, developmentPoints: 7 },
  { value: 86, spentPoints: 86, bonus: 8, developmentPoints: 8 },
  { value: 90, spentPoints: 90, bonus: 8, developmentPoints: 8 },
  { value: 91, spentPoints: 92, bonus: 9, developmentPoints: 9 },
  { value: 92, spentPoints: 94, bonus: 9, developmentPoints: 9 },
  { value: 93, spentPoints: 96, bonus: 9, developmentPoints: 9 },
  { value: 94, spentPoints: 98, bonus: 9, developmentPoints: 9 },
  { value: 95, spentPoints: 100, bonus: 9, developmentPoints: 9 },
  { value: 96, spentPoints: 103, bonus: 10, developmentPoints: 10 },
  { value: 97, spentPoints: 106, bonus: 10, developmentPoints: 10 },
  { value: 98, spentPoints: 109, bonus: 10, developmentPoints: 10 },
  { value: 99, spentPoints: 112, bonus: 10, developmentPoints: 10 },
  { value: 100, spentPoints: 115, bonus: 10, developmentPoints: 10 },
  { value: 101, spentPoints: 125, bonus: 11, developmentPoints: 11 },
  { value: 102, spentPoints: 135, bonus: 12, developmentPoints: 12 },
  { value: 103, spentPoints: 145, bonus: 13, developmentPoints: 13 },
  { value: 104, spentPoints: 155, bonus: 14, developmentPoints: 14 },
  { value: 105, spentPoints: 165, bonus: 15, developmentPoints: 15 }
]

describe('Testing Stat', () => {
  test('Should throw error if value less than zero', () => {
    expect(() => { Stat.fromValue(StatCode.PRESENCE, -1) }).toThrowError(StatValueError)
  })
  test('Should throw error if value above 105', () => {
    expect(() => { Stat.fromValue(StatCode.PRESENCE, 106) }).toThrowError(StatValueError)
  })
  test('Should return proper values when initialized from code', () => {
    const stat = Stat.fromCode(StatCode.STRENGTH)
    expect(stat.rawValue()).toBe(0)
    expect(stat.code()).toBe('ST')
  })
  test('Should return proper values', () => {
    for (const equivalence of EQUIVALENCES) {
      const stat = Stat.fromValue(StatCode.STRENGTH, equivalence.value)
      expect(stat.rawValue()).toBe(equivalence.value)
      expect(stat.developmentPoints()).toBe(equivalence.developmentPoints)
      expect(stat.bonus()).toBe(equivalence.bonus)
      expect(stat.spentPoints()).toBe(equivalence.spentPoints)
    }
  })
  test('Should return proper values from spentPoints constructor', () => {
    for (const equivalence of EQUIVALENCES) {
      const stat = Stat.fromSpentPoints(StatCode.STRENGTH, equivalence.spentPoints)
      expect(stat.rawValue()).toBe(equivalence.value)
    }
  })
  test('Should return proper values from intermediate spent points', () => {
    const stat = Stat.fromSpentPoints(StatCode.CONSTITUTION, 91)
    expect(stat.rawValue()).toBe(90)
    expect(stat.spentPoints()).toBe(91)
  })
  test('Should throw error if increase raises stat above limit', () => {
    const stat = Stat.fromValue(StatCode.CONSTITUTION, 105)
    expect(() => { stat.increase(1) }).toThrowError(StatOutOfBoundsError)
  })
  test('Should throw error if spentPoints exceeds the maximum', () => {
    const stat = Stat.fromValue(StatCode.CONSTITUTION, 104)
    expect(() => { stat.increase(11) }).toThrowError(StatOutOfBoundsError)
  })
  test('Should throw error if increase called with negative value', () => {
    const stat = Stat.fromValue(StatCode.CONSTITUTION, 100)
    expect(() => { stat.increase(-1) }).toThrowError(StatValueError)
  })
  test('Should increase value', () => {
    const stat = Stat.fromSpentPoints(StatCode.CONSTITUTION, 144)
    const updatedStat = stat.increase(1)
    expect(stat.rawValue()).toBe(102)
    expect(updatedStat.rawValue()).toBe(103)
  })
  test('Should not increase value but keep spentPoints track', () => {
    const stat = Stat.fromValue(StatCode.CONSTITUTION, 102)
    const updatedStat = stat.increase(9)
    expect(stat.rawValue()).toBe(102)
    expect(stat.spentPoints()).toBe(135)
    expect(updatedStat.rawValue()).toBe(102)
    expect(updatedStat.spentPoints()).toBe(144)
  })
  test('Should throw error if reduce lowers stat below limit', () => {
    const stat = Stat.fromValue(StatCode.CONSTITUTION, 0)
    expect(() => { stat.reduce(1) }).toThrowError(StatOutOfBoundsError)
  })
  test('Should throw error if spentPoints exceeds the minimum', () => {
    const stat = Stat.fromValue(StatCode.CONSTITUTION, 2)
    expect(() => { stat.reduce(3) }).toThrowError(StatOutOfBoundsError)
  })
  test('Should throw error if reduce called with negative value', () => {
    const stat = Stat.fromValue(StatCode.CONSTITUTION, 100)
    expect(() => { stat.reduce(-1) }).toThrowError(StatValueError)
  })
  test('Should decrease value', () => {
    const stat = Stat.fromValue(StatCode.CONSTITUTION, 90)
    const updatedStat = stat.reduce(1)
    expect(stat.rawValue()).toBe(90)
    expect(updatedStat.rawValue()).toBe(89)
  })
  test('Should not decrease value but keep track of SpentPoints', () => {
    const stat = Stat.fromSpentPoints(StatCode.CONSTITUTION, 101)
    const updatedStat = stat.reduce(1)
    expect(stat.rawValue()).toBe(95)
    expect(stat.spentPoints()).toBe(101)
    expect(updatedStat.rawValue()).toBe(95)
    expect(updatedStat.spentPoints()).toBe(100)
  })
})
