import { LoginUserCommand } from '@/Application/User/Command/LoginUserCommand'
import { LogoutUserCommand } from '@/Application/User/Command/LogoutUserCommand'
import { RefreshUserCommand } from '@/Application/User/Command/RefreshUserCommand'
import { UserHandlerProvider } from '@/Application/User/UserHandlerProvider'
import { UserHandlerItems } from '@/Application/User/UserHandlerItems'
import { defineStore } from 'pinia'

const userHandlerProvider = new UserHandlerProvider()

export const useUserStore = defineStore('users', {
  state: () => ({
    token: '',
    username: '',
    role: ''
  }),
  getters: {
    isLogged: state => state.username !== '' && state.role !== '',
    userRole (state): string {
      return this.isLogged ? state.role : ''
    }
  },
  actions: {
    async login (username: string, password: string): Promise<boolean> {
      const command = new LoginUserCommand(username, password)
      const handler = userHandlerProvider.provide(UserHandlerItems.LOGIN_USER_COMMAND)
      try {
        const response = await handler.handle(command)
        this.username = response.username
        this.token = response.token
        this.role = response.role
        return true
      } catch (e) {
        console.log('login', e)
        this.$reset()
        return false
      }
    },
    async logout (): Promise<void> {
      const command = new LogoutUserCommand()
      const handler = userHandlerProvider.provide(UserHandlerItems.LOGOUT_USER_COMMAND)
      await handler.handle(command)
      this.$reset()
    },
    async refresh (): Promise<boolean> {
      const refreshToken = window.localStorage.getItem('refreshToken')
      const command = new RefreshUserCommand(refreshToken ?? '')
      try {
        const handler = userHandlerProvider.provide(UserHandlerItems.REFRESH_USER_COMMAND)
        const response = await handler.handle(command)
        this.username = response.username
        this.token = response.token
        this.role = response.role
        return true
      } catch (e) {
        console.log('refresh', e)
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
