import { describe, test, expect, beforeEach } from 'vitest'
import { LogoutUserCommand } from '@/Application/User/Command/LogoutUserCommand'
import { LogoutUserCommandHandler } from '@/Application/User/Command/LogoutUserCommandHandler'
import { UserRepositoryError } from '@/Domain/User/UserRepositoryError'
import { mockUserRepository } from './mockUtils'

const mockedUserRepository = mockUserRepository()

describe('Testing LogoutUserCommandHandler', () => {
  let sut: LogoutUserCommandHandler
  let command: LogoutUserCommand

  beforeEach(() => {
    sut = new LogoutUserCommandHandler(mockedUserRepository)
    command = new LogoutUserCommand()
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(LogoutUserCommandHandler)
  })
  test('Should throw error if user cannot be deleted', () => {
    mockedUserRepository.remove.mockImplementationOnce(() => { throw new UserRepositoryError('UserRepositoryError') })
    expect(() => {
      sut.handle(command)
    }).toThrow(UserRepositoryError)
  })
  test('Should return true if user deleted properly', () => {
    mockedUserRepository.remove.mockReturnValue(true)
    const response = sut.handle(command)
    expect(response).toBe(true)
  })
})
