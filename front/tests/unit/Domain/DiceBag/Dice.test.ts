import { Dice } from '@/Domain/DiceBag/Dice'
import { describe, test, expect } from 'vitest'

describe('Testing Dice', () => {
  test('Should be of proper class', () => {
    const dice = Dice.fromSides('6')
    expect(dice).toBeInstanceOf(Dice)
  })
  test('It should return proper number of sides', () => {
    const dice = Dice.fromSides('6')
    expect(dice.sides()).toBe(6)
  })
  test('It should return always proper value when rolled', () => {
    const dice = Dice.fromSides('6')
    for (let i = 0; i < 20; i++) {
      const roll = dice.roll()
      expect(roll >= 1 && roll <= 6).toBe(true)
    }
  })
})
