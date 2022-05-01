export class LoginUserCommand {
  private _username: string
  private _password: string

  constructor (username: string, password: string) {
    this._username = username
    this._password = password
  }
  public username(): string {
    return this._username
  }
  public password(): string {
    return this._password
  }
}
