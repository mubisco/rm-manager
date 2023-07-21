import { User } from '@/Domain/User/User'

export interface UserRepository {
  store(user: User): Promise<User>
  get(): Promise<User>
  remove(): void
}
