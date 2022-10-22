import { InvalidUsernameError } from '@/Domain/User/InvalidUsernameError'

const USERNAME_REGEX = /^[0-9a-zA-Z_]*$/

export class Username {
  private _value: string

  constructor (name: string) {
    const regex = RegExp(USERNAME_REGEX)
    if (!regex.test(name)) {
      throw new InvalidUsernameError(`${name} is not a valid Username!!!`)
    }
    this._value = name
  }

  public value (): string {
    return this._value
  }
}
