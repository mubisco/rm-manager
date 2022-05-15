import { vi } from 'vitest'

const mockUserClient = () => {
  return {
    refresh: vi.fn(),
    login: vi.fn(),
    resetPassword: vi.fn()
  }
}

const mockUserRepository = () => {
  return {
    store: vi.fn(),
    remove: vi.fn()
  }
}

export { mockUserRepository, mockUserClient }
