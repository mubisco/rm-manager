import { AxiosPasswordTokenClient } from '@/Infrastructure/User/Client/AxiosPasswordTokenClient'
import { describe, test, expect, vi } from 'vitest'
import axios, {AxiosError} from 'axios'
import {PasswordTokenNotFoundError} from '@/Domain/User/PasswordToken/PasswordTokenNotFoundError'
import {PasswordTokenExpiredError} from '@/Domain/User/PasswordToken/PasswordTokenExpiredError'

vi.mock('axios', () => ({
  default: {
    get: vi.fn(),
  }
}))


describe('Testing AxiosPasswordTokenClient', () => {
  test('it should be of proper class', () => {
    const sut = new AxiosPasswordTokenClient()
    expect(sut).toBeInstanceOf(AxiosPasswordTokenClient)
  })
  test('it should return PasswordTokenNotFoundError if 404 status', async () => {
    const error = new Error('message')
    error.response = {
      status: 404,
      statusText: 'asd',
      headers: {},
      config: {},
      request: {},
      data: { error: 'Request error' }
    }
    axios.get.mockRejectedValue(error)
    const sut = new AxiosPasswordTokenClient()
    await expect(sut.statusByToken('asd')).rejects.toThrow(PasswordTokenNotFoundError)
  })
  test('it should return PasswordTokenExpiredError if 400 status', async () => {
    const error = new Error('message')
    error.response = {
      status: 400,
      statusText: 'asd',
      headers: {},
      config: {},
      request: {},
      data: { error: 'Request error' }
    }
    axios.get.mockRejectedValue(error)
    const sut = new AxiosPasswordTokenClient()
    await expect(sut.statusByToken('asd')).rejects.toThrow(PasswordTokenExpiredError)
  })
  test('it should return true', async () => {
    axios.get.mockResolvedValue({ status: 200, data: { message: 'Valid token' } })
    const sut = new AxiosPasswordTokenClient()
    await expect(sut.statusByToken('asd')).resolves.toBeTruthy()
  })
})

