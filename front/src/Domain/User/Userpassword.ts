import { InvalidPasswordError } from '@/Domain/User/InvalidPasswordError'

const PASSWORD_REGEX = /^\w{6,}$/

export class Userpassword {
  private _value: string

  constructor (value: string) {
    const regex = RegExp(PASSWORD_REGEX)
    if (!regex.test(value)) {
      throw new InvalidPasswordError('Password provided has wrong format!!!')
    }
    this._value = value
  }

  public value (): string {
    return this._value
  }
}
