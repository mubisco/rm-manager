import { beforeEach, describe, test, expect, vi } from 'vitest'
import { LoginUserCommandHandler } from '@/Application/Command/User/LoginUserCommandHandler'
import { LoginUserCommand } from '@/Application/Command/User/LoginUserCommand'
import { InvalidUsernameError } from '@/Domain/User/InvalidUsernameError'
import { InvalidPasswordError } from '@/Domain/User/InvalidPasswordError'
import { UserClientError } from '@/Domain/User/UserClientError'
import { UserRepositoryError } from '@/Domain/User/UserRepositoryError'
import { User } from '@/Domain/User/User'
import { UserRole } from '@/Domain/User/UserRole'
import { Username } from '@/Domain/User/Username'

const mockedUserClient = {
  login: vi.fn()
}

describe('LoginUserCommandTest', () => {
  let sut: LoginUserCommandHandler
  let command: LoginUserCommand

  beforeEach(() => {
    sut = new LoginUserCommandHandler(mockedUserClient)
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
    mockedUserClient.login.mockReturnValue(new User(new Username('mubisco'), UserRole.ADMIN))
    await expect(sut.handle(command)).rejects.toThrow(UserRepositoryError)
  })
})
