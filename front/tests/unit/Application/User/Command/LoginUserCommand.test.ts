import { describe, test, expect } from 'vitest'
import { LoginUserCommand } from '@/Application/User/Command/LoginUserCommand'

describe('LoginUserCommand', () => {
  test('Should return proper data', () => {
    const sut = new LoginUserCommand('username', 'password')
    expect(sut.username()).toBe('username')
    expect(sut.password()).toBe('password')
  })
})
