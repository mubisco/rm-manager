import { LoginUserCommand } from '@/Application/Command/User/LoginUserCommand'
import { LoggedUserDto } from '@/Application/Command/User/LoggedUserDto'
import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { UserClient } from '@/Domain/User/UserClient'
import { UserRepository } from '@/Domain/User/UserRepository'

export class LoginUserCommandHandler {
  private userClient: UserClient
  private userRepository: UserRepository

  constructor (
    userClient: UserClient,
    userRepository: UserRepository
  ) {
    this.userClient = userClient
    this.userRepository = userRepository
  }

  public async handle (command: LoginUserCommand): Promise<LoggedUserDto> {
    const username = new Username(command.username())
    const password = new Userpassword(command.password())
    const user = await this.userClient.login(username, password)
    await this.userRepository.store(user)
    return {
      username: user.username(),
      role: user.role(),
      token: user.token(),
      refreshToken: user.refreshToken()
    }
  }
}
