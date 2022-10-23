import { InvalidTokenError } from '@/Domain/User/InvalidTokenError'
import { UserClient } from '@/Domain/User/UserClient'
import { Userpassword } from '@/Domain/User/Userpassword'
import { UserHandler } from '../UserHandler'
import { ChangePasswordCommand } from './ChangePasswordCommand'

export class ChangePasswordCommandHandler implements UserHandler<ChangePasswordCommand, Promise<void>> {
  private _userClient: UserClient

  constructor (userClient: UserClient) {
    this._userClient = userClient
  }

  async handle (command: ChangePasswordCommand): Promise<void> {
    const newPassword = new Userpassword(command.newPassword)
    if (command.token === '') {
      throw new InvalidTokenError('Token cannot be empty!!!')
    }
    await this._userClient.changePassword(newPassword, command.token)
  }
}
