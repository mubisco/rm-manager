import { ProfessionName } from './ProfessionName'

export interface ProfessionNameReadModel {
  fetchNames(): Promise<ProfessionName[]>
}
