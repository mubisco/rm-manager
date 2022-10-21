import { Username } from '@/Domain/User/Username'
import { Userpassword } from '@/Domain/User/Userpassword'
import { User } from '@/Domain/User/User'

export interface UserClient {
  login(name: Username, pass: Userpassword): Promise<User>
  refresh(token: string): Promise<User>
  resetPassword(name: Username): Promise<boolean>
  changePassword(name: Userpassword, token: string): Promise<boolean>
}
