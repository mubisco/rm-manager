import { AxiosProfessionReadModel } from '@/Infrastructure/Character/Profession/ReadModel/Axios/AxiosProfessionReadModel'
import { ProfessionNameReadModelError } from '@/Application/Profession/Query/ProfessionNameReadModelError'
import { vi, beforeEach, describe, test, expect } from 'vitest'
import axios, { AxiosError } from 'axios'
import professionNamesData from './professionNamesResponse.json'
import professionDetailsData from './professionDetails.json'
import { ProfessionName } from '@/Application/Profession/Query/ProfessionName'
import { ProfessionCode } from '@/Domain/Character/Profession/ProfessionCode'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
import { UserRepository } from '@/Domain/User/UserRepository'
import { User } from '@/Domain/User/User'
import { Username } from '@/Domain/User/Username'
import { UserRole } from '@/Domain/User/UserRole'
import { ProfessionReadModelError } from '@/Application/Profession/Query/ProfessionReadModelError'
import { ProfessionNotFoundError } from '@/Application/Profession/Query/ProfessionNotFoundError'

vi.mock('axios', () => ({
  default: {
    get: vi.fn(),
    post: vi.fn(),
    patch: vi.fn(),
    put: vi.fn()
  }
}))

const mockUserRepository = () => {
  return {
    store: vi.fn(),
    remove: vi.fn(),
    get: vi.fn()
  }
}

const mockProperUserRepositoryResponse = () => {
  mockedUserRepository.get.mockImplementationOnce(() => {
    return new User(new Username('mubisco'), UserRole.USER, 'asd', 'asd')
  })
}

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
let mockedUserRepository: UserRepository

describe('Testing AxiosProfessionReadModel', () => {
  beforeEach(() => {
    mockedUserRepository = mockUserRepository()
    sut = new AxiosProfessionReadModel(mockedUserRepository)
  })
  test('Should be of proper class', () => {
    expect(sut).toBeInstanceOf(AxiosProfessionReadModel)
  })
  test('Should throw exception when 400 error', () => {
    mockProperUserRepositoryResponse()
    axios.get.mockRejectedValue(mockAxiosError(400))
    expect(sut.fetchNames()).rejects.toThrow(ProfessionNameReadModelError)
  })
  test('Should throw exception when 500 error', () => {
    mockProperUserRepositoryResponse()
    axios.get.mockRejectedValue(mockAxiosError(500))
    expect(sut.fetchNames()).rejects.toThrow(ProfessionNameReadModelError)
  })
  test('Should throw exception when no User found', () => {
    axios.get.mockResolvedValue({ data: professionNamesData })
    mockedUserRepository.get.mockImplementationOnce(() => {
      throw new UserNotFoundError('UserRepositoryError')
    })
    expect(sut.fetchNames()).rejects.toThrow(ProfessionNameReadModelError)
  })
  test('Should return proper values', async () => {
    mockProperUserRepositoryResponse()
    axios.get.mockResolvedValue({ data: professionNamesData })
    const result = await sut.fetchNames()
    expect(result).toHaveLength(3)
    result.forEach((item: ProfessionName) => {
      expect(item.code).toBeDefined()
      expect(item.name).toBeDefined()
      expect(Object.values(ProfessionCode).includes(item.code)).toBeTruthy()
    })
  })
  test('Should throw exception in profession details when 400 error', () => {
    mockProperUserRepositoryResponse()
    axios.get.mockRejectedValue(mockAxiosError(400))
    expect(sut.ofCode(ProfessionCode.MONK)).rejects.toThrowError(ProfessionReadModelError)
  })
  test('Should throw exception in profession details when 404 error', () => {
    mockProperUserRepositoryResponse()
    axios.get.mockRejectedValue(mockAxiosError(404))
    expect(sut.ofCode(ProfessionCode.MONK)).rejects.toThrowError(ProfessionNotFoundError)
  })
  test('Should return proper ProfessionDto', async () => {
    mockProperUserRepositoryResponse()
    axios.get.mockResolvedValue({ data: professionDetailsData })
    const result = await sut.ofCode(ProfessionCode.MONK)
    expect(result.code).toBe('monk')
    expect(result.name).toBe('Monje')
  })
})
