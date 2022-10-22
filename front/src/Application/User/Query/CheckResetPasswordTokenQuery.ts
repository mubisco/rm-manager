export class CheckResetPasswordTokenQuery {
  public readonly token: string

  constructor (token: string) {
    this.token = token
  }
}
