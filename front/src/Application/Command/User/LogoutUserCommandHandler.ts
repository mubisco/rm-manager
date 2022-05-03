import { LogoutUserCommand } from '@/Application/Command/User/LogoutUserCommand'
import { UserRepository } from '@/Domain/User/UserRepository'

export class LogoutUserCommandHandler {
  constructor(
    private userRepository: UserRepository
  ) {
  }
  public handle(command: LogoutUserCommand): boolean {
    this.userRepository.remove()
    return true
  }
}
