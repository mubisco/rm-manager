import { UserClient } from '@/Domain/User/UserClient'
import { Username } from '@/Domain/User/Username'
import { ResetPasswordCommand } from '@/Application/Command/User/ResetPasswordCommand'

export class ResetPasswordCommandHandler {
  private client: UserClient

  constructor(client: UserClient) {
    this.client = client
  }
  async handle(command: ResetPasswordCommand): Promise<boolean> {
    const username = new Username(command.username())
    await this.client.resetPassword(username)
    return true
  }
}
