import { User } from '@/Domain/User/User'
import { Username } from '@/Domain/User/Username'
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
    const user = new User(new Username('mubisco'), UserRole.ADMIN, 'aToken')
    const result = await sut.store(user)
    expect(result).toBe(user)
  })
  test('Should store data in localstorage', async () => {
    const sut = new StorageUserRepository()
    const user = new User(new Username('mubisco'), UserRole.ADMIN, 'aToken')
    await sut.store(user)
    const rawData = localStorage.getItem('userData')
    const data = rawData !== null ? JSON.parse(rawData) : {}
    expect(data.username).toBe('mubisco')
    expect(data.role).toBe('ADMIN')
    expect(data.token).toBe('aToken')
  })
  test('Should remove data in localStorage', async () => {
    localStorage.setItem('userData', '{}')
    const sut = new StorageUserRepository()
    await sut.remove()
    const rawData = localStorage.getItem('userData')
    expect(rawData).toBeNull()
  });
})
