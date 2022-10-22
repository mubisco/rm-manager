import { describe, test, expect, beforeEach, afterAll, vi } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import { useUserStore } from '@/UI/stores/user'

const fakeLoginSuccessResponse = { username: 'mubisco', token: 'asd', role: 'USER', refreshToken: 'refresh' }
const fakeRefreshSuccessResponse = { username: 'mubisco', token: 'newToken', role: 'USER', refreshToken: 'newRefreshToken' }

vi.mock('../../../../src/Application/Command/User/LoginUserCommandHandler.ts', () => {
  return {
    LoginUserCommandHandler: vi.fn(() => ({
      handle: vi.fn()
        .mockImplementationOnce(() => Promise.reject(new Error('asd')))
        .mockImplementationOnce(() => Promise.resolve(fakeLoginSuccessResponse))
        .mockImplementationOnce(() => Promise.resolve(fakeLoginSuccessResponse))
    }))
  }
})
vi.mock('../../../../src/Application/Command/User/LogoutUserCommandHandler.ts', () => {
  return {
    LogoutUserCommandHandler: vi.fn(() => ({
      handle: vi.fn()
    }))
  }
})
vi.mock('../../../../src/Application/Command/User/RefreshUserCommandHandler.ts', () => {
  return {
    RefreshUserCommandHandler: vi.fn(() => ({
      handle: vi.fn()
        .mockImplementationOnce(() => Promise.reject(new Error('asd')))
        .mockImplementationOnce(() => Promise.reject(new Error('asd')))
        .mockImplementationOnce(() => {
          window.localStorage.setItem('refreshToken', fakeRefreshSuccessResponse.refreshToken)
          return Promise.resolve(fakeRefreshSuccessResponse)
        })
    }))
  }
})
describe('Testing user store', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })
  afterAll(() => {
    vi.clearAllMocks()
  })
  test('Should have proper initial state', () => {
    const userStore = useUserStore()
    expect(userStore.token).toBe('')
    expect(userStore.username).toBe('')
    expect(userStore.role).toBe('')
    expect(userStore.isLogged).toBe(false)
  })
  test('Should return false if login fails', async () => {
    const userStore = useUserStore()
    const response = await userStore.login('mubisco', 'badpassword')
    expect(response).toBe(false)
  })
  test('Should return true if login successful', async () => {
    const userStore = useUserStore()
    const response = await userStore.login('mubisco', 'badpassword')
    expect(response).toBe(true)
    expect(userStore.token).toBe('asd')
    expect(userStore.username).toBe('mubisco')
    expect(userStore.role).toBe('USER')
    expect(userStore.isLogged).toBe(true)
  })
  test('Should reset values if logout', async () => {
    const userStore = useUserStore()
    await userStore.login('mubisco', 'badpassword')
    await userStore.logout()
    expect(userStore.token).toBe('')
    expect(userStore.username).toBe('')
    expect(userStore.role).toBe('')
    expect(userStore.isLogged).toBe(false)
  })
  test('Should return false if no refresh token set', async () => {
    const userStore = useUserStore()
    const response = await userStore.refresh()
    expect(response).toBe(false)
  })
  test('Should return false if refresh token calls fails', async () => {
    window.localStorage.setItem('refreshToken', 'refreshToken')
    const userStore = useUserStore()
    const response = await userStore.refresh()
    expect(response).toBe(false)
  })
  test('Should return true if refresh token call succeeded', async () => {
    window.localStorage.setItem('refreshToken', 'refreshToken')
    const userStore = useUserStore()
    const response = await userStore.refresh()
    expect(response).toBe(true)
    expect(userStore.token).toBe('newToken')
    expect(userStore.username).toBe('mubisco')
    expect(userStore.role).toBe('USER')
    expect(userStore.isLogged).toBe(true)
    const refreshToken = window.localStorage.getItem('refreshToken')
    expect(refreshToken).toBe('newRefreshToken')
  })
})
