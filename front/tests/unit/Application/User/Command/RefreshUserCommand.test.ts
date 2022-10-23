import { describe, test, expect } from 'vitest'
import { RefreshUserCommand } from '@/Application/User/Command/RefreshUserCommand'

describe('Testing RefreshUserCommand', () => {
  test('Should be of proper class', () => {
    const sut = new RefreshUserCommand()
    expect(sut).toBeInstanceOf(RefreshUserCommand)
  })
  test('Should return proper token value', () => {
    const sut = new RefreshUserCommand()
    expect(sut.token()).toBe('')
  })
  test('Should return proper token value from different instance', () => {
    const sut = new RefreshUserCommand('token')
    expect(sut.token()).toBe('token')
  })
})
