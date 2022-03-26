import { LoginUserCommand } from '@/Application/Command/User/LoginUserCommand'
import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'

export class LoginUserCommandHandler {
  public handle(command: LoginUserCommand): any {
    new Username(command.username())
    new Userpassword(command.password())
  }
}
