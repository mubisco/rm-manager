import { describe, test, expect } from 'vitest'
import { LogoutUserCommand } from '@/Application/Command/User/LogoutUserCommand'

describe('Testing LogoutUserCommand', () => {
  test('Should be of proper class', () => {
    const sut = new LogoutUserCommand()
    expect(sut).toBeInstanceOf(LogoutUserCommand)
  })
})
