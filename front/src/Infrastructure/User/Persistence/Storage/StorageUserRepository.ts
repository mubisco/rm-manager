import { User } from '@/Domain/User/User'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
import { UserRepository } from '@/Domain/User/UserRepository'
import { Username } from '@/Domain/User/Username'

export class StorageUserRepository implements UserRepository {
  async store (user: User): Promise<User> {
    const data = {
      username: user.username(),
      role: user.role(),
      token: user.token()
    }
    window.localStorage.setItem('userData', JSON.stringify(data))
    window.localStorage.setItem('refreshToken', user.refreshToken())
    return user
  }

  async get (): Promise<User> {
    const userData = window.localStorage.getItem('userData')
    const refreshToken = window.localStorage.getItem('refreshToken')
    if (!userData) {
      return Promise.reject(new UserNotFoundError('No user data found!!!'))
    }
    if (refreshToken === null) {
      return Promise.reject(new UserNotFoundError('No refresh token found!!!'))
    }
    const parsedUserData = JSON.parse(userData)
    return Promise.resolve(new User(
      new Username(parsedUserData.username),
      parsedUserData.role,
      parsedUserData.token,
      refreshToken
    ))
  }

  remove (): void {
    localStorage.removeItem('userData')
    localStorage.removeItem('refreshToken')
  }
}
