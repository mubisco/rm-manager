import { describe, test, expect, beforeEach } from 'vitest'
import { ResetPasswordCommandHandler } from '@/Application/Command/User/ResetPasswordCommandHandler'
import { ResetPasswordCommand } from '@/Application/Command/User/ResetPasswordCommand'
import { UserClientError } from '@/Domain/User/UserClientError'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
import { mockUserClient } from './mockUtils'

const mockedUserClient = mockUserClient()

let sut: ResetPasswordCommandHandler
const command = new ResetPasswordCommand('mubisco')

describe('Testing ResetPasswordCommandHandler', () => {
  beforeEach(() => {
    sut = new ResetPasswordCommandHandler(mockedUserClient)
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(ResetPasswordCommandHandler)
  })
  test('Should throw error if request fails', async () => {
    mockedUserClient.resetPassword.mockRejectedValue(new UserClientError('Error'))
    await expect(sut.handle(command)).rejects.toThrow(UserClientError)
  })
  test('Should throw error if user sent does not exists', async () => {
    mockedUserClient.resetPassword.mockRejectedValue(new UserNotFoundError('Error'))
    await expect(sut.handle(command)).rejects.toThrow(UserNotFoundError)
  })
  test('Should return true if user does exists', async () => {
    mockedUserClient.resetPassword.mockResolvedValue(true)
    await expect(sut.handle(command)).resolves.toBe(true)
  })
})
