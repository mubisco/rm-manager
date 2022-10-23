export class RefreshUserCommand {
  private _token: string

  constructor (token?: string) {
    this._token = token ?? ''
  }

  public token (): string {
    return this._token
  }
}
