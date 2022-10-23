import { PasswordTokenRepository } from '@/Domain/User/PasswordToken/PassowrdTokenRepository'
import { PasswordTokenExpiredError } from '@/Domain/User/PasswordToken/PasswordTokenExpiredError'
import { PasswordTokenNotFoundError } from '@/Domain/User/PasswordToken/PasswordTokenNotFoundError'
import { UserHandler } from '@/Application/User/UserHandler'
import { CheckResetPasswordTokenQuery } from './CheckResetPasswordTokenQuery'

export class CheckResetPasswordTokenQueryHandler implements UserHandler<CheckResetPasswordTokenQuery, Promise<string>> {
  private tokenRepository: PasswordTokenRepository

  constructor (tokenRepository: PasswordTokenRepository) {
    this.tokenRepository = tokenRepository
  }

  public async handle (query: CheckResetPasswordTokenQuery): Promise<string> {
    try {
      await this.tokenRepository.statusByToken(query.token)
    } catch (e) {
      if (e instanceof PasswordTokenNotFoundError) {
        return 'NOT_FOUND'
      }
      if (e instanceof PasswordTokenExpiredError) {
        return 'EXPIRED'
      }
    }
    return 'OK'
  }
}
