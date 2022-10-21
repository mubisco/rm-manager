import { CheckResetPasswordTokenQuery } from '@/Application/User/Query/CheckResetPasswordTokenQuery'
import { CheckResetPasswordTokenQueryHandler } from '@/Application/User/Query/CheckResetPasswordTokenQueryHandler'
import { PasswordTokenExpiredError } from '@/Domain/User/PasswordToken/PasswordTokenExpiredError'
import { PasswordTokenNotFoundError } from '@/Domain/User/PasswordToken/PasswordTokenNotFoundError'
import { describe, test, expect, vi, beforeEach } from 'vitest'

const mockedRepository = {
  statusByToken: vi.fn()
}

describe('Testing CheckResetPasswordTokenQueryHandler', () => {
  let sut: CheckResetPasswordTokenQueryHandler
  let query: CheckResetPasswordTokenQuery

  beforeEach(() => {
    query = new CheckResetPasswordTokenQuery('asd')
    sut = new CheckResetPasswordTokenQueryHandler(mockedRepository)
  })
  test('it should return NOT_FOUND if token not found', async () => {
    mockedRepository.statusByToken.mockRejectedValue(new PasswordTokenNotFoundError('Async test error'))
    await expect(sut.handle(query)).resolves.toBe('NOT_FOUND')
  })
  test('it should throw expired token if token expired', async () => {
    mockedRepository.statusByToken.mockRejectedValue(new PasswordTokenExpiredError('Async test error'))
    await expect(sut.handle(query)).resolves.toBe('EXPIRED')
  })
  test('it should return true if token valid', async () => {
    mockedRepository.statusByToken.mockResolvedValue(true)
    const response = await sut.handle(query)
    expect(response).toBe('OK')
  })
})
