import { beforeEach, describe, test, expect } from 'vitest'
import { LoginUserCommandHandler } from '@/Application/Command/User/LoginUserCommandHandler'
import { LoginUserCommand } from '@/Application/Command/User/LoginUserCommand'
import { InvalidUsernameError } from '@/Domain/User/InvalidUsernameError'
import { InvalidPasswordError } from '@/Domain/User/InvalidPasswordError'
import { UserClientError } from '@/Domain/User/UserClientError'
import { UserRepositoryError } from '@/Domain/User/UserRepositoryError'
import { User } from '@/Domain/User/User'
import { UserRole } from '@/Domain/User/UserRole'
import { Username } from '@/Domain/User/Username'
import { mockUserClient, mockUserRepository } from './mockUtils'

const mockedUserClient = mockUserClient()
const mockedUserRepository = mockUserRepository()

describe('LoginUserCommandTest', () => {
  let sut: LoginUserCommandHandler
  let command: LoginUserCommand

  beforeEach(() => {
    sut = new LoginUserCommandHandler(mockedUserClient, mockedUserRepository)
    command = new LoginUserCommand('username', 'password')
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(LoginUserCommandHandler)
  })
  test('Should throw error if username has wrong format', async () => {
    const wrongCommand = new LoginUserCommand('xan@server.net', 'somepassword')
    await expect(sut.handle(wrongCommand)).rejects.toThrow(InvalidUsernameError)
  })
  test('Should throw error if password has wrong format', async () => {
    const wrongCommand = new LoginUserCommand('username', 'pass')
    await expect(sut.handle(wrongCommand)).rejects.toThrow(InvalidPasswordError)
  })
  test('Should throw Error if client fails', async () => {
    mockedUserClient.login.mockRejectedValue(new UserClientError('Async test error'))
    await expect(sut.handle(command)).rejects.toThrow(UserClientError)
  })
  test('Should throw Error if user cannot be stored', async () => {
    mockedUserClient.login.mockReturnValue(new User(new Username('mubisco'), UserRole.ADMIN, '', ''))
    mockedUserRepository.store.mockRejectedValue(new UserRepositoryError('UserRepositoryError'))
    await expect(sut.handle(command)).rejects.toThrow(UserRepositoryError)
  })
  test('Should return true if user stored properly', async () => {
    const mockedUser = new User(new Username('mubisco'), UserRole.ADMIN, 'aToken', 'refreshToken');
    mockedUserClient.login.mockReturnValue(mockedUser)
    mockedUserRepository.store.mockReturnValue(mockedUser)
    const result = await sut.handle(command)
    expect(result.username).toBe('mubisco')
    expect(result.role).toBe('ADMIN')
    expect(result.token).toBe('aToken')
    expect(result.refreshToken).toBe('refreshToken')
  })
})
