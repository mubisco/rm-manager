export class ChangePasswordCommand {
  constructor(
    public readonly token: string,
    public readonly newPassword: string
  ) {
  }
}
