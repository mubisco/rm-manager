import { AxiosProfessionReadModel } from '@/Infrastructure/Character/Profession/ReadModel/Axios/AxiosProfessionReadModel'
import { ProfessionNameReadModelError } from '@/Application/Profession/Query/ProfessionNameReadModelError'
import { vi, beforeEach, describe, test, expect } from 'vitest'
import axios, { AxiosError } from 'axios'
import professionNamesData from './professionNamesResponse.json'
import { ProfessionName } from '@/Application/Profession/Query/ProfessionName'
import { ProfessionCode } from '@/Domain/Character/Profession/ProfessionCode'

vi.mock('axios', () => ({
  default: {
    get: vi.fn(),
    post: vi.fn(),
    patch: vi.fn(),
    put: vi.fn()
  }
}))

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

let sut: AxiosProfessionReadModel

describe('Testing AxiosProfessionReadModel', () => {
  beforeEach(() => {
    sut = new AxiosProfessionReadModel()
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(AxiosProfessionReadModel)
  })
  test('Should throw exception when 400 error', async () => {
    axios.get.mockRejectedValue(mockAxiosError(400))
    await expect(sut.fetchNames()).rejects.toThrow(ProfessionNameReadModelError)
  })
  test('Should throw exception when 500 error', async () => {
    axios.get.mockRejectedValue(mockAxiosError(500))
    await expect(sut.fetchNames()).rejects.toThrow(ProfessionNameReadModelError)
  })
  test('Should return proper values', async () => {
    axios.get.mockResolvedValue({ data: professionNamesData })
    const result = await sut.fetchNames()
    expect(result).toHaveLength(3)
    result.forEach((item: ProfessionName) => {
      expect(item.code).toBeDefined()
      expect(item.name).toBeDefined()
      expect(Object.values(ProfessionCode).includes(item.code)).toBeTruthy()
    })
  })
})
