import { describe, test, expect } from 'vitest'
import { LogoutUserCommand } from '@/Application/User/Command/LogoutUserCommand'

describe('Testing LogoutUserCommand', () => {
  test('Should be of proper class', () => {
    const sut = new LogoutUserCommand()
    expect(sut).toBeInstanceOf(LogoutUserCommand)
  })
})
