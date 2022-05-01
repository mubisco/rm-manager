import { LoginUserCommand } from '@/Application/Command/User/LoginUserCommand'
import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { UserClient } from '@/Domain/User/UserClient'
import { UserRepositoryError } from '@/Domain/User/UserRepositoryError'

export class LoginUserCommandHandler {
  constructor(
    private userClient: UserClient
  ) {
  }

  public async handle(command: LoginUserCommand): Promise<void> {
    const username = new Username(command.username())
    const password = new Userpassword(command.password())
    await this.userClient.login(username, password)
    throw new UserRepositoryError('mes')
  }
}
