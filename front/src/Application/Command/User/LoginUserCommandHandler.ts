import { LoginUserCommand } from '@/Application/Command/User/LoginUserCommand'
import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { UserClient } from '@/Domain/User/UserClient'
import { UserRepository } from '@/Domain/User/UserRepository'

export class LoginUserCommandHandler {
  constructor(
    private userClient: UserClient,
    private userRepository: UserRepository
  ) {
  }

  public async handle(command: LoginUserCommand): Promise<boolean> {
    const username = new Username(command.username())
    const password = new Userpassword(command.password())
    const user = await this.userClient.login(username, password)
    await this.userRepository.store(user)
    return true
  }
}
