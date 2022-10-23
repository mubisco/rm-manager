import { LogoutUserCommand } from '@/Application/User/Command/LogoutUserCommand'
import { UserRepository } from '@/Domain/User/UserRepository'

export class LogoutUserCommandHandler {
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
