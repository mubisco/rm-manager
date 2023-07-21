import { User } from '@/Domain/User/User'
import { Username } from '@/Domain/User/Username'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
import { UserRole } from '@/Domain/User/UserRole'
import { StorageUserRepository } from '@/Infrastructure/User/Persistence/Storage/StorageUserRepository'
import { describe, test, expect } from 'vitest'

describe('Testing StorageUserRepository', () => {
  test('Should be of proper class', () => {
    const sut = new StorageUserRepository()
    expect(sut).toBeInstanceOf(StorageUserRepository)
  })
  test('Should return user when stored', async () => {
    const sut = new StorageUserRepository()
    const user = new User(new Username('mubisco'), UserRole.ADMIN, 'aToken', 'refreshToken')
    const result = await sut.store(user)
    expect(result).toBe(user)
  })
  test('Should store data in localstorage', async () => {
    const sut = new StorageUserRepository()
    const user = new User(new Username('mubisco'), UserRole.ADMIN, 'aToken', 'refreshToken')
    await sut.store(user)
    const rawData = localStorage.getItem('userData')
    const refreshToken = localStorage.getItem('refreshToken')
    const data = rawData !== null ? JSON.parse(rawData) : {}
    expect(data.username).toBe('mubisco')
    expect(data.role).toBe('ADMIN')
    expect(data.token).toBe('aToken')
    expect(refreshToken).toBe('refreshToken')
  })
  test('Should remove user data in localStorage', () => {
    localStorage.setItem('userData', '{}')
    const sut = new StorageUserRepository()
    sut.remove()
    const rawData = localStorage.getItem('userData')
    expect(rawData).toBeNull()
    const token = localStorage.getItem('refreshToken')
    expect(token).toBeNull()
  })

  test('Should throw error when user not found', () => {
    const sut = new StorageUserRepository()
    expect(sut.get()).rejects.toThrowError(UserNotFoundError)
  })

  test('Should return proper user when exists', async () => {
    const sut = new StorageUserRepository()
    const userData = {
      username: 'mubisco',
      role: 'USER',
      token: 'aVeryLargeToken'
    }
    localStorage.setItem('userData', JSON.stringify(userData))
    localStorage.setItem('refreshToken', 'anotherVeryLargeToken')
    const user = await sut.get()
    expect(user).toBeInstanceOf(User)
    expect(user.username()).toBe('mubisco')
    expect(user.role()).toBe(UserRole.USER)
    expect(user.token()).toBe('aVeryLargeToken')
    expect(user.refreshToken()).toBe('anotherVeryLargeToken')
  })
})
