import { LogoutUserCommand } from '@/Application/Command/User/LogoutUserCommand'
import { UserRepository } from '@/Domain/User/UserRepository'

export class LogoutUserCommandHandler {
  constructor(
    private userRepository: UserRepository
  ) {
  }
  public handle(command: LogoutUserCommand): boolean {
    console.log('hanle logout')
    this.userRepository.remove()
    return true
  }
}
