export class Dice {
  private _sides: number

  public static fromSides (sides: string): Dice {
    return new Dice(parseInt(sides, 10))
  }

  private constructor (sides: number) {
    this._sides = sides
  }

  sides (): number {
    return this._sides
  }

  roll (): number {
    return Math.floor((Math.random() * this._sides) + 1)
  }
}
