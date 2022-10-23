import { describe, test, expect } from 'vitest'
import { ResetPasswordCommand } from '@/Application/User/Command/ResetPasswordCommand'

describe('Testing ResetPasswordCommand', () => {
  test('Should return proper username', () => {
    const sut = new ResetPasswordCommand('mubisco')
    expect(sut.username()).toBe('mubisco')
  })
})
