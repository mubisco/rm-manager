import { StatCode } from './StatCode'
import { StatValueError } from './StatValueError'

const LOWER_LIMIT = 0
const UPPER_LIMIT = 105

export class Stat {
  private _code: StatCode
  private _value: number

  static fromCode (code: StatCode): Stat {
    return new this(code, LOWER_LIMIT)
  }

  static fromValue (code: StatCode, value: number): Stat {
    return new this(code, value)
  }

  private constructor (code: StatCode, value: number) {
    this.validateValue(value)
    this._code = code
    this._value = value
  }

  code (): string {
    return this._code.toString()
  }

  rawValue (): number {
    return this._value
  }

  increase (delta: number): void {
    if (delta < 1) {
      throw new StatValueError('Cannot increase stat with negative value!!')
    }
    const updatedValue = this._value + delta
    this.validateValue(updatedValue)
    this._value = updatedValue
  }

  reduce (delta: number): void {
    if (delta < 1) {
      throw new StatValueError('Cannot reduce stat with negative value!!')
    }
    const updatedValue = this._value - delta
    this.validateValue(updatedValue)
    this._value = updatedValue
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

  private validateValue (value: number): void {
    if (value < LOWER_LIMIT) {
      throw new StatValueError('Stat cannot have value less than zero')
    }
    if (value > UPPER_LIMIT) {
      throw new StatValueError('Stat cannot have value above 105')
    }
  }
}
