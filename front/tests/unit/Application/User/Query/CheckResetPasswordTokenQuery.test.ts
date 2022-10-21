import { CheckResetPasswordTokenQuery } from '@/Application/User/Query/CheckResetPasswordTokenQuery'
import { describe, test, expect } from 'vitest'

describe('Testing CheckResetPasswordTokenQuery', () => {
  test('Should return proper token value', () => {
    const sut = new CheckResetPasswordTokenQuery('aVeryLargeToken')
    expect(sut.token).toBe('aVeryLargeToken')
  })
})
