import { LoggedUserDto } from '@/Application/User/Command/LoggedUserDto'
import { InvalidRefreshTokenError } from '@/Domain/User/InvalidRefreshTokenError'
import { RefreshUserCommand } from '@/Application/User/Command/RefreshUserCommand'
import { UserClient } from '@/Domain/User/UserClient'
import { UserRepository } from '@/Domain/User/UserRepository'
import { UserHandler } from '@/Application/User/UserHandler'

export class RefreshUserCommandHandler implements UserHandler<RefreshUserCommand, Promise<LoggedUserDto>> {
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
