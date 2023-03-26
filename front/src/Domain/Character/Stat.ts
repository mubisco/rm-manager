import { StatCode } from './StatCode'
import { StatOutOfBoundsError } from './StatOutOfBoundsError'
import { StatValueError } from './StatValueError'

const LOWER_LIMIT = 0
const UPPER_LIMIT = 105
const UPPER_SPENT_POINTS_LIMIT = 165

export class Stat {
  private _code: StatCode
  private _value: number
  private _spentPoints: number

  static fromCode (code: StatCode): Stat {
    return new this(code, LOWER_LIMIT)
  }

  static fromValue (code: StatCode, value: number): Stat {
    return new this(code, Stat.calculateSpentPoints(value))
  }

  static fromSpentPoints (code: StatCode, spentPoints: number): Stat {
    return new this(code, spentPoints)
  }

  private spentPointsToValue (spentPoints: number): number {
    if (spentPoints <= 90) {
      return spentPoints
    }
    if (spentPoints <= 100) {
      return 90 + Math.floor((spentPoints - 90) / 2)
    }
    if (spentPoints <= 115) {
      return 95 + Math.floor((spentPoints - 100) / 3)
    }
    return 100 + Math.floor((spentPoints - 115) / 10)
  }

  private constructor (code: StatCode, spentPoints: number) {
    const value = this.spentPointsToValue(spentPoints)
    if (value < LOWER_LIMIT || value > UPPER_LIMIT) {
      throw new StatValueError('Stat cannot have value between 0 and 105')
    }
    this._code = code
    this._value = value
    this._spentPoints = spentPoints
  }

  code (): string {
    return this._code.toString()
  }

  rawValue (): number {
    return this._value
  }

  spentPoints (): number {
    return this._spentPoints
  }

  increase (delta: number): Stat {
    if (this._value === UPPER_LIMIT) {
      throw new StatOutOfBoundsError(`This stat (${this._value}) cannot be increased`)
    }
    if (delta < 1) {
      throw new StatValueError('Cannot increase stat with negative value!!')
    }
    const updatedSpentPoints = this._spentPoints + delta
    if (updatedSpentPoints > UPPER_SPENT_POINTS_LIMIT) {
      throw new StatOutOfBoundsError('Development points spent exceeds the maximum')
    }
    return Stat.fromSpentPoints(this._code, updatedSpentPoints)
  }

  reduce (delta: number): Stat {
    if (this._value === LOWER_LIMIT) {
      throw new StatOutOfBoundsError(`This stat (${this._value}) cannot be reduced`)
    }
    if (delta < 1) {
      throw new StatValueError('Cannot reduce stat with negative value!!')
    }
    const updatedSpentPoints = this._spentPoints - delta
    if (updatedSpentPoints < 0) {
      throw new StatOutOfBoundsError('Development points spent below minimum')
    }
    return Stat.fromSpentPoints(this._code, updatedSpentPoints)
  }

  bonus (): number {
    const mod = Math.ceil(this._value / 5)
    if (this._value > 100) {
      return this._value - 90
    }
    if (mod === 10) {
      return 0
    }
    if (mod < 10) {
      return (mod - 10) * 2
    }
    return mod - 10
  }

  developmentPoints (): number {
    if (this._value > 100) {
      return this._value - 90
    }
    if (this._value > 50) {
      return Math.ceil((this._value - 50) / 5)
    }
    if (this._value > 30) {
      return 0.75
    }
    if (this._value > 10) {
      return 0.50
    }
    return 0.25
  }

  private static calculateSpentPoints (rawValue: number): number {
    if (rawValue <= 90) {
      return rawValue
    }
    if (rawValue <= 95) {
      return 90 + (rawValue - 90) * 2
    }
    if (rawValue <= 100) {
      return 100 + (rawValue - 95) * 3
    }
    return 115 + (rawValue - 100) * 10
  }
}
