import { LoginUserCommand } from '@/Application/User/Command/LoginUserCommand'
import { LoginUserCommandHandler } from '@/Application/User/Command/LoginUserCommandHandler'
import { LogoutUserCommand } from '@/Application/User/Command/LogoutUserCommand'
import { LogoutUserCommandHandler } from '@/Application/User/Command/LogoutUserCommandHandler'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { StorageUserRepository } from '@/Infrastructure/User/Persistence/Storage/StorageUserRepository'
import { RefreshUserCommandHandler } from '@/Application/User/Command/RefreshUserCommandHandler'
import { RefreshUserCommand } from '@/Application/User/Command/RefreshUserCommand'
import { defineStore } from 'pinia'

const axiosUserClient = new AxiosUserClient()
const storageUserRepository = new StorageUserRepository()
const loginUserCommandHandler = new LoginUserCommandHandler(axiosUserClient, storageUserRepository)
const logoutUserCommandHandler = new LogoutUserCommandHandler(storageUserRepository)
const refreshUserCommandHandler = new RefreshUserCommandHandler(axiosUserClient, storageUserRepository)

export const useUserStore = defineStore('users', {
  state: () => ({
    token: '',
    username: '',
    role: ''
  }),
  getters: {
    isLogged: state => state.username !== '' && state.role !== ''
  },
  actions: {
    async login (username: string, password: string): Promise<boolean> {
      const command = new LoginUserCommand(username, password)
      try {
        const response = await loginUserCommandHandler.handle(command)
        this.username = response.username
        this.token = response.token
        this.role = response.role
        return true
      } catch (e) {
        this.$reset()
        return false
      }
    },
    async logout (): Promise<void> {
      const command = new LogoutUserCommand()
      logoutUserCommandHandler.handle(command)
      this.$reset()
    },
    async refresh (): Promise<boolean> {
      const refreshToken = window.localStorage.getItem('refreshToken')
      const command = new RefreshUserCommand(refreshToken ?? '')
      try {
        const response = await refreshUserCommandHandler.handle(command)
        this.username = response.username
        this.token = response.token
        this.role = response.role
        return true
      } catch {
        window.localStorage.removeItem('refreshToken')
        this.$reset()
        return false
      }
    },
    loadFromStorage (): void {
      const rawSavedUser = window.localStorage.getItem('userData')
      if (rawSavedUser) {
        const savedUser = JSON.parse(rawSavedUser)
        this.username = savedUser.username
        this.token = savedUser.token
        this.role = savedUser.role
      }
    }
  }
})
