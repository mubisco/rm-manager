import { describe, test, expect, beforeEach } from 'vitest'
import { RefreshUserCommandHandler } from '@/Application/Command/User/RefreshUserCommandHandler'
import { RefreshUserCommand } from '@/Application/Command/User/RefreshUserCommand'
import { InvalidRefreshTokenError } from '@/Domain/User/InvalidRefreshTokenError'
import { UserClientError } from '@/Domain/User/UserClientError'
import { UserRepositoryError } from '@/Domain/User/UserRepositoryError'
import { User } from '@/Domain/User/User'
import { UserRole } from '@/Domain/User/UserRole'
import { Username } from '@/Domain/User/Username'
import { mockUserClient, mockUserRepository } from './mockUtils'

let command: RefreshUserCommand
let sut: RefreshUserCommandHandler

const mockedUserClient = mockUserClient()
const mockedUserRepository = mockUserRepository()

describe('Testing RefreshUserCommandHandler', () => {
  beforeEach(() => {
    sut = new RefreshUserCommandHandler(mockedUserClient, mockedUserRepository)
    command = new RefreshUserCommand('refreshToken')
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(RefreshUserCommandHandler)
  })
  test('Should throw error if RefreshToken empty', async () => {
    await expect(sut.handle(new RefreshUserCommand())).rejects.toThrow(InvalidRefreshTokenError)
  })
  test('Should throw error if Client fails', async () => {
    mockedUserClient.refresh.mockRejectedValue(new UserClientError('Async test error'))
    await expect(sut.handle(command)).rejects.toThrow(UserClientError)
  })
  test('Should throw Error if user cannot be stored', async () => {
    mockedUserClient.refresh.mockResolvedValue(new User(new Username('mubisco'), UserRole.ADMIN, '', ''))
    mockedUserRepository.store.mockRejectedValue(new UserRepositoryError('UserRepositoryError'))
    await expect(sut.handle(command)).rejects.toThrow(UserRepositoryError)
  })
  test('Should return true if user stored properly', async () => {
    const mockedUser = new User(new Username('mubisco'), UserRole.ADMIN, 'aToken', 'refreshToken')
    mockedUserClient.refresh.mockResolvedValue(mockedUser)
    mockedUserRepository.store.mockResolvedValue(mockedUser)
    const result = await sut.handle(command)
    expect(result.username).toBe('mubisco')
    expect(result.role).toBe('ADMIN')
    expect(result.token).toBe('aToken')
    expect(result.refreshToken).toBe('refreshToken')
  })
})
