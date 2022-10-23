import { AxiosPasswordTokenClient } from '@/Infrastructure/User/Client/AxiosPasswordTokenClient'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { StorageUserRepository } from '@/Infrastructure/User/Persistence/Storage/StorageUserRepository'
import { ChangePasswordCommandHandler } from './Command/ChangePasswordCommandHandler'
import { LoginUserCommandHandler } from './Command/LoginUserCommandHandler'
import { LogoutUserCommandHandler } from './Command/LogoutUserCommandHandler'
import { RefreshUserCommandHandler } from './Command/RefreshUserCommandHandler'
import { ResetPasswordCommandHandler } from './Command/ResetPasswordCommandHandler'
import { CheckResetPasswordTokenQueryHandler } from './Query/CheckResetPasswordTokenQueryHandler'
import { UserHandler } from './UserHandler'
import { UserHandlerItems } from './UserHandlerItems'

export class UserHandlerProvider {
  // eslint-disable-next-line
  private equivalences: { [K: string]: Function } = {
    ChangePasswordCommandHandler: this.createChangePasswordCommandHandler,
    LoginUserCommandHandler: this.createLoginUserCommandHandler,
    LogoutUserCommandHandler: this.createLogoutUserCommandHandler,
    RefreshUserCommandHandler: this.createRefreshUserCommandHandler,
    ResetPasswordCommandHandler: this.createResetPasswordCommandHandler,
    CheckResetPasswordTokenQueryHandler: this.createCheckResetPasswordTokenQueryHandler
  }

  provide (handler: UserHandlerItems): UserHandler {
    return this.equivalences[handler]()
  }

  private createChangePasswordCommandHandler (): ChangePasswordCommandHandler {
    return new ChangePasswordCommandHandler(new AxiosUserClient())
  }

  private createLoginUserCommandHandler (): LoginUserCommandHandler {
    return new LoginUserCommandHandler(new AxiosUserClient(), new StorageUserRepository())
  }

  private createLogoutUserCommandHandler (): LogoutUserCommandHandler {
    return new LogoutUserCommandHandler(new StorageUserRepository())
  }

  private createRefreshUserCommandHandler (): RefreshUserCommandHandler {
    return new RefreshUserCommandHandler(new AxiosUserClient(), new StorageUserRepository())
  }

  private createResetPasswordCommandHandler (): ResetPasswordCommandHandler {
    return new ResetPasswordCommandHandler(new AxiosUserClient())
  }

  private createCheckResetPasswordTokenQueryHandler (): CheckResetPasswordTokenQueryHandler {
    return new CheckResetPasswordTokenQueryHandler(new AxiosPasswordTokenClient())
  }
}
