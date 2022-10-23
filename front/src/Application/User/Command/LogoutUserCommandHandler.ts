import { LogoutUserCommand } from '@/Application/User/Command/LogoutUserCommand'
import { UserRepository } from '@/Domain/User/UserRepository'
import { UserHandler } from '@/Application/User/UserHandler'

export class LogoutUserCommandHandler implements UserHandler<LogoutUserCommand, boolean> {
  private userRepository: UserRepository

  constructor (userRepository: UserRepository) {
    this.userRepository = userRepository
  }

  // eslint-disable-next-line
  public handle (command: LogoutUserCommand): boolean {
    this.userRepository.remove()
    return true
  }
}
