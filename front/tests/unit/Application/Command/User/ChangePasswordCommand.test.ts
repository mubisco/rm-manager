import { ChangePasswordCommand } from '@/Application/Command/User/ChangePasswordCommand'
import { describe, test, expect } from 'vitest'

describe('Testing ChangePasswordCommand', () => {
  test('Should return proper data', () => {
    const sut = new ChangePasswordCommand('aToken', 'newPassword')
    expect(sut.token).toBe('aToken')
    expect(sut.newPassword).toBe('newPassword')
  })
})
