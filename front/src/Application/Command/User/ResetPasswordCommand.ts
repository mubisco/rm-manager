export class ResetPasswordCommand {
  constructor(private _username: string) {
  }
  username(): string {
    return this._username
  }
}
