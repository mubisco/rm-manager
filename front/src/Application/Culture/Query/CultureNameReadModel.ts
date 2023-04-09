import { CultureName } from './CultureName'

export interface CultureNameReadModel {
  fetchNames (): Promise<CultureName[]>
}
