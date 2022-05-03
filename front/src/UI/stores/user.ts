import {LoginUserCommand} from '@/Application/Command/User/LoginUserCommand';
import { LoginUserCommandHandler } from '@/Application/Command/User/LoginUserCommandHandler';
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient';
import { StorageUserRepository } from '@/Infrastructure/User/Persistence/Storage/StorageUserRepository';
import { defineStore } from 'pinia'

const loginUserCommandHandler = new LoginUserCommandHandler(new AxiosUserClient(), new StorageUserRepository());

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
      } catch {
        this.username = ''
        this.token = ''
        this.role = ''
        return false
      }
    },
    async refreshToken(): Promise<void> {
      const response = await fetch('/api/login/renew', {
        method: 'GET',
        headers: { 'Authorization': `Bearer ${this.token}` }
      })
      if (response.status !== 200) {
        this.token = ''
      }
      // const parsedReponse = await response.json();
    }
  }
})
