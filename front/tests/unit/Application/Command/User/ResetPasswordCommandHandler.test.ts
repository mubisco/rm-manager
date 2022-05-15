import { describe, test, expect, vi, beforeEach } from 'vitest'
import { ResetPasswordCommandHandler } from '@/Application/Command/User/ResetPasswordCommandHandler'

describe('Testing ResetPasswordCommandHandler', () => {
  test('Should be of proper class', () => {
    const sut = new ResetPasswordCommandHandler()
    expect(sut).toBeInstanceOf(ResetPasswordCommandHandler)
  })
})
