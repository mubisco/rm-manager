import { ChangePasswordCommandHandler } from '@/Application/User/Command/ChangePasswordCommandHandler'
import { LoginUserCommandHandler } from '@/Application/User/Command/LoginUserCommandHandler'
import { UserHandlerItems } from '@/Application/User/UserHandlerItems'
import { UserHandlerProvider } from '@/Application/User/UserHandlerProvider'
import { describe, test, expect } from 'vitest'

describe('Testing UserHandlerProvider', () => {
  test('Should return proper handler', () => {
    const sut = new UserHandlerProvider()
    const result = sut.provide(UserHandlerItems.CHANGE_PASSWORD_COMMAND)
    expect(result).toBeInstanceOf(ChangePasswordCommandHandler)
  })
  test('Should return another handler', () => {
    const sut = new UserHandlerProvider()
    const result = sut.provide(UserHandlerItems.LOGIN_USER_COMMAND)
    expect(result).toBeInstanceOf(LoginUserCommandHandler)
  })
})
