import { describe, test, expect, beforeEach, vi } from 'vitest'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { User } from '@/Domain/User/User'
import { UserClientError } from '@/Domain/User/UserClientError'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
import axios from 'axios'
import tokenExamples from './tokenExamples.json'

vi.mock('axios', () => ({
  default: {
    post: vi.fn(),
    put: vi.fn()
  }
}))

let sut: AxiosUserClient

describe('Testing AxiosUserClient', () => {
  beforeEach(() => {
    sut = new AxiosUserClient()
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(AxiosUserClient)
  })
  test('Should throw exception if login fails', async () => {
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
    const expectedError = new Error('Message')
    expectedError.response = {
      data: {},
      statusText: '',
      config: {},
      headers: {},
      status: 500
    }
    axios.put.mockRejectedValue(expectedError)
    await expect(sut.resetPassword(new Username('mubisco'))).rejects.toThrow(UserClientError)
  })
  test('Should throw error if username to reset password does not exists', async () => {
    const expectedError = new Error('Message')
    expectedError.response = {
      data: {},
      statusText: '',
      config: {},
      headers: {},
      status: 404
    }
    axios.put.mockRejectedValue(expectedError)
    await expect(sut.resetPassword(new Username('mubisco'))).rejects.toThrow(UserNotFoundError)
  })
  test('Should return true if reset password done', async () => {
    axios.put.mockResolvedValue()
    await expect(sut.resetPassword(new Username('mubisco'))).resolves.toBe(true)
  })
})
