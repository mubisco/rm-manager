export class ResetPasswordCommand {
  private _username: string

  constructor (username: string) {
    this._username = username
  }

  username (): string {
    return this._username
  }
}
