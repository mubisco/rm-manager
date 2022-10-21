export interface PasswordTokenRepository {
  statusByToken(token: string): Promise<boolean>
}
