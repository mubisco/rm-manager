import { User } from '@/Domain/User/User'

export interface UserRepository {
  async store(user: User): Promise<User>
}
