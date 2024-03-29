import { describe, test, expect, beforeEach, vi } from 'vitest'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { User } from '@/Domain/User/User'
import { UserClientError } from '@/Domain/User/UserClientError'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
import axios, { AxiosError } from 'axios'
import tokenExamples from './tokenExamples.json'

vi.mock('axios', () => ({
  default: {
    post: vi.fn(),
    patch: vi.fn(),
    put: vi.fn()
  }
}))

let sut: AxiosUserClient

const mockAxiosError = (statusCode: number) => {
  const expectedError = new Error('Message') as AxiosError
  expectedError.response = {
    data: {},
    statusText: '',
    config: {},
    headers: {},
    status: statusCode
  }
  return expectedError
}

describe('Testing AxiosUserClient', () => {
  beforeEach(() => {
    sut = new AxiosUserClient()
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(AxiosUserClient)
  })
  test('Should throw exception if login fails', async () => {
    // eslint-disable-next-line
    axios.post.mockRejectedValue(new Error('Message'))
    await expect(sut.login(new Username('mubisco'), new Userpassword('patatas'))).rejects.toThrow(UserClientError)
  })
  test('Should return User if connection goes well', async () => {
    axios.post.mockResolvedValue({
      data: { token: tokenExamples.admin, refresh_token: 'refreshToken' }
    })
    await expect(sut.login(new Username('mubisco'), new Userpassword('patatas'))).resolves.toBeInstanceOf(User)
  })
  test('Should throw exception if refresh fails', async () => {
    axios.post.mockRejectedValue(new Error('Message'))
    await expect(sut.refresh('refreshToken')).rejects.toThrow(UserClientError)
  })
  test('Should return User if refresh call returns data', async () => {
    axios.post.mockResolvedValue({
      data: { token: tokenExamples.admin, refresh_token: 'refreshToken' }
    })
    await expect(sut.refresh('refreshToken')).resolves.toBeInstanceOf(User)
  })
  test('Should throw error if client fails when resetting password', async () => {
    axios.put.mockRejectedValue(mockAxiosError(500))
    await expect(sut.resetPassword(new Username('mubisco'))).rejects.toThrow(UserClientError)
  })
  test('Should throw error if username to reset password does not exists', async () => {
    axios.put.mockRejectedValue(mockAxiosError(404))
    await expect(sut.resetPassword(new Username('mubisco'))).rejects.toThrow(UserNotFoundError)
  })
  test('Should return true if reset password done', async () => {
    axios.put.mockResolvedValue()
    await expect(sut.resetPassword(new Username('mubisco'))).resolves.toBe(true)
  })

  test('Should throw error if password cannot be changed', async () => {
    axios.patch.mockRejectedValue(mockAxiosError(500))
    await expect(sut.changePassword(new Userpassword('s3cretP4ssword'), 'aToken')).rejects.toThrow(UserClientError)
  })
  test('Should return true if reset password done', async () => {
    axios.patch.mockResolvedValue(true)
    await expect(sut.changePassword(new Userpassword('s3cretP4ssword'), 'aToken')).resolves.toBe(true)
  })
})
