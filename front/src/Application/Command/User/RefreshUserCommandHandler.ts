import { LoggedUserDto } from '@/Application/Command/User/LoggedUserDto'
import { InvalidRefreshTokenError } from '@/Domain/User/InvalidRefreshTokenError'
import { RefreshUserCommand } from '@/Application/Command/User/RefreshUserCommand'
import { UserClient } from '@/Domain/User/UserClient'
import { UserRepository } from '@/Domain/User/UserRepository'

export class RefreshUserCommandHandler {
  private userClient: UserClient
  private userRepository: UserRepository

  constructor (
    userClient: UserClient,
    userRepository: UserRepository
  ) {
    this.userClient = userClient
    this.userRepository = userRepository
  }

  public async handle (command: RefreshUserCommand): Promise<LoggedUserDto> {
    if (command.token() === '') {
      throw new InvalidRefreshTokenError('Refresh token provided is empty')
    }
    const user = await this.userClient.refresh(command.token())
    await this.userRepository.store(user)
    return {
      username: user.username(),
      role: user.role(),
      token: user.token(),
      refreshToken: user.refreshToken()
    }
  }
}
