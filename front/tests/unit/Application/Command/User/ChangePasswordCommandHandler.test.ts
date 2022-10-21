import { ChangePasswordCommand } from '@/Application/Command/User/ChangePasswordCommand'
import { ChangePasswordCommandHandler } from '@/Application/Command/User/ChangePasswordCommandHandler'
import { InvalidPasswordError } from '@/Domain/User/InvalidPasswordError'
import { InvalidTokenError } from '@/Domain/User/InvalidTokenError'
import { UserClientError } from '@/Domain/User/UserClientError'
import { describe, test, expect, beforeEach } from 'vitest'
import { mockUserClient } from './mockUtils'

const mockedUserClient = mockUserClient()

let sut: ChangePasswordCommandHandler
const command = new ChangePasswordCommand('aToken', 's3cureP4ssword')

describe('Testing ChangePasswordCommandHandler', () => {
  beforeEach(() => {
    sut = new ChangePasswordCommandHandler(mockedUserClient)
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(ChangePasswordCommandHandler)
  })
  test('Should throw error if password not valid', async () => {
    await expect(sut.handle(new ChangePasswordCommand('aToken', 'asd')))
      .rejects.toThrow(InvalidPasswordError)
  })
  test('Should throw error if token empty', async () => {
    await expect(sut.handle(new ChangePasswordCommand('', 's3cureP4ssword')))
      .rejects.toThrow(InvalidTokenError)
  })
  test('Should throw error if client fails', async () => {
    mockedUserClient.changePassword.mockRejectedValue(new UserClientError('Error'))
    await expect(sut.handle(command)).rejects.toThrow(UserClientError)
  })
  test('Should execute without errors', async () => {
    mockedUserClient.changePassword.mockResolvedValue(true)
    await sut.handle(command)
    expect(true).toBe(true)
  })
})
