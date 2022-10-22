export class ChangePasswordCommand {
  public readonly token: string
  public readonly newPassword: string

  constructor (token: string, newPassword: string) {
    this.token = token
    this.newPassword = newPassword
  }
}
