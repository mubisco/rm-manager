import { User } from '@/Domain/User/User'
import { UserRepository } from '@/Domain/User/UserRepository'

export class StorageUserRepository implements UserRepository {
  async store(user: User): Promise<User> {
    const data = {
      username: user.username(),
      role: user.role(),
      token: user.token(),
    }
    localStorage.setItem('userData', JSON.stringify(data))
    localStorage.setItem('refreshToken', user.refreshToken())
    return user
  }
  remove(): void {
    localStorage.removeItem('userData')
  }
}
