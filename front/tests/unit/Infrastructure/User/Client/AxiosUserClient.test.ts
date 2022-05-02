import { describe, test, expect, vi } from 'vitest'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { User } from '@/Domain/User/User'
import { UserClientError } from '@/Domain/User/UserClientError'
import axios from 'axios'
import tokenExamples from './tokenExamples.json'

vi.mock('axios', () => ({
  default: {
    post: vi.fn()
  }
}))

describe('Testing AxiosUserClient', () => {
  test('Should be of proper class', () => {
    const sut = new AxiosUserClient()
    expect(sut).toBeInstanceOf(AxiosUserClient)
  })
  test('Should throw exception if login fails', async () => {
    const sut = new AxiosUserClient()
    axios.post.mockRejectedValue(new Error('Message'))
    await expect(sut.login(new Username('mubisco'), new Userpassword('patatas'))).rejects.toThrow(UserClientError)
  })
  test('Should return User if connection goes well', async () => {
    const sut = new AxiosUserClient()
    axios.post.mockResolvedValue({
      data: { token: tokenExamples.admin }
    })
    await expect(sut.login(new Username('mubisco'), new Userpassword('patatas'))).resolves.toBeInstanceOf(User)
  })
})
