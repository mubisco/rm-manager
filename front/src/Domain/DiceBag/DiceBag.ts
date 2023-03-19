import { Dice } from "./Dice"
import { RollResultDto } from "./RollResultDto"

const BAG_REGEX = /^([0-9]+?)??[Dd]([0-9]{1,3})([+-][0-9]+)?$/

export class DiceBag {
  private _diceNumber: number
  private _diceSides: string
  private _modifier: number
  private _dices: Dice[]

  public static fromString (value: string): DiceBag {
    return new DiceBag(value)
  }

  private constructor (value: string) {
    if (!BAG_REGEX.test(value)) {
      throw new RangeError(value + ' Value provided for Dicebag not valid')
    }
    const result = BAG_REGEX.exec(value)
    this._diceNumber = result && result[1] ? parseInt(result[1], 10) : 1
    this._diceSides = result && result[2] ? result[2] : ''
    this._modifier = result && result[3] ? parseInt(result[3], 10) : 0
    this._dices = []
    this.createDices()
  }

  private createDices (): void {
    for (let dices = 0; dices < this._diceNumber; dices++) {
      this._dices.push(Dice.fromSides(this._diceSides))
    }
  }

  roll (): RollResultDto {
    const breakdown:number[] = []
    this._dices.forEach((dice: Dice) => {
      breakdown.push(dice.roll())
    })
    return {
      total: breakdown.reduce((sum, current) => sum + current, 0) + this._modifier,
      rollBreakdown: breakdown,
      modifier: this._modifier
    }
  }

  toString (): string {
    let result = ''
    result += this._diceNumber
    result += 'd'
    result += this._diceSides
    if (this._modifier > 0) {
      result += '+'
    }
    if (this._modifier !== 0) {
      result += this._modifier
    }
    return result
  }
}
