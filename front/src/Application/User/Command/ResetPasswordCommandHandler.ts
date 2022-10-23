import { UserClient } from '@/Domain/User/UserClient'
import { Username } from '@/Domain/User/Username'
import { UserHandler } from '@/Application/User/UserHandler'
import { ResetPasswordCommand } from '@/Application/User/Command/ResetPasswordCommand'

export class ResetPasswordCommandHandler implements UserHandler<ResetPasswordCommand, Promise<boolean>> {
  private client: UserClient

  constructor (client: UserClient) {
    this.client = client
  }

  async handle (command: ResetPasswordCommand): Promise<boolean> {
    const username = new Username(command.username())
    await this.client.resetPassword(username)
    return true
  }
}
