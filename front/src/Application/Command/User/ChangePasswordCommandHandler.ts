import {InvalidTokenError} from "@/Domain/User/InvalidTokenError";
import {UserClient} from "@/Domain/User/UserClient";
import { Userpassword } from "@/Domain/User/Userpassword";
import { ChangePasswordCommand } from "./ChangePasswordCommand";

export class ChangePasswordCommandHandler {
  constructor (private _userClient: UserClient) {}

  async handle(command: ChangePasswordCommand): Promise<void> {
    const newPassword = new Userpassword(command.newPassword)
    if (command.token === '') {
      throw new InvalidTokenError('Token cannot be empty!!!')
    }
    await this._userClient.changePassword(newPassword, command.token)
  }
}
