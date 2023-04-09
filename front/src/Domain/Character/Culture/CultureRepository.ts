import { CultureName } from './CultureName'

export interface CultureRepository {
  fetchNames(): Promise<CultureName[]>
}
