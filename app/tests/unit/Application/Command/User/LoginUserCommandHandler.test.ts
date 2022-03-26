import { describe, test, expect } from 'vitest'
import { LoginUserCommandHandler } from '@/Application/Command/User/LoginUserCommandHandler'
import { LoginUserCommand } from '@/Application/Command/User/LoginUserCommand'
import { InvalidUsernameError } from '@/Domain/User/InvalidUsernameError'
import { InvalidPasswordError } from '@/Domain/User/InvalidPasswordError'

describe('LoginUserCommandTest', () => {
  test('Should be of proper class', () => {
    const sut = new LoginUserCommandHandler()
    expect(sut).toBeInstanceOf(LoginUserCommandHandler)
  })
  test('Should throw error if username has wrong format', () => {
    const sut = new LoginUserCommandHandler()
    const command = new LoginUserCommand('xan@server.net', 'somepassword')
    expect(() => sut.handle(command)).toThrowError(InvalidUsernameError)
  })
  test('Should throw error if password has wrong format', () => {
    const sut = new LoginUserCommandHandler()
    const command = new LoginUserCommand('username', 'pass')
    expect(() => sut.handle(command)).toThrowError(InvalidPasswordError)
  })
})
