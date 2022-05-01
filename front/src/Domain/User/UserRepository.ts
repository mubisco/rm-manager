import { User } from '@/Domain/User/User'

export interface UserRepository {
  store(user: User): User
}
