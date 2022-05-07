import { User } from '@/Domain/User/User'
import { UserRepository } from '@/Domain/User/UserRepository'

export class StorageUserRepository implements UserRepository {
  async store(user: User): Promise<User> {
    const data = {
      username: user.username(),
      role: user.role(),
      token: user.token(),
      refreshToken: user.refreshToken()
    }
    localStorage.setItem('userData', JSON.stringify(data))
    return user
  }
  remove(): void {
    localStorage.removeItem('userData')
  }
}
