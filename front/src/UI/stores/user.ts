import { LoginUserCommand } from '@/Application/Command/User/LoginUserCommand';
import { LoginUserCommandHandler } from '@/Application/Command/User/LoginUserCommandHandler';
import { LogoutUserCommand } from '@/Application/Command/User/LogoutUserCommand';
import { LogoutUserCommandHandler } from '@/Application/Command/User/LogoutUserCommandHandler';
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient';
import { StorageUserRepository } from '@/Infrastructure/User/Persistence/Storage/StorageUserRepository';
import { RefreshUserCommandHandler } from '@/Application/Command/User/RefreshUserCommandHandler';
import { defineStore } from 'pinia'
import {RefreshUserCommand} from '@/Application/Command/User/RefreshUserCommand';

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
    async login(username: string, password: string): Promise<boolean> {
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
    async logout(): Promise<void> {
      const command = new LogoutUserCommand()
      logoutUserCommandHandler.handle(command)
      this.$reset()
    },
    async refresh(): Promise<boolean> {
      const refreshToken = window.localStorage.getItem('refreshToken')
      const command = new RefreshUserCommand(refreshToken ?? '')
      try {
        const response = await refreshUserCommandHandler.handle(command)
        this.username = response.username
        this.token = response.token
        this.role = response.role
        return true
      } catch  {
        this.$reset()
        return false
      }
      /*
      const data = { refresh_token: refreshToken }
      const response = await fetch(import.meta.env.VITE_API_URL + '/api/token/refresh', {
        method: 'POST',
        body: JSON.stringify(data)
      })
      if (response.status === 200) {
        const responseData = await response.json()
        this.token = responseData.token
        this.username = 'mubisco'
        this.role = 'ADMIN'
        const userData = {
          username: this.username,
          token: this.token,
          role: this.role
        }
        window.localStorage.setItem('userData', JSON.stringify(userData))
        window.localStorage.setItem('refreshToken', responseData.refresh_token)
        return true
      } else {
        window.localStorage.removeItem('userData')
        window.localStorage.removeItem('refreshToken')
        return false
      }
    */
    }
  }
})
