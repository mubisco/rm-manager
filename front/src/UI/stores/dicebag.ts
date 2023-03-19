import { RollResultDto } from '@/Domain/DiceBag/RollResultDto'
import { defineStore } from 'pinia'

export const useDicebagStore = defineStore('dicebag', {
  state: () => ({
    totalRolled: 0,
    dicebagDefinition: '',
    breakdown: [] as number[]
  }),
  getters: {
    rolledValue: state => state.totalRolled,
    definition: state => state.dicebagDefinition
  },
  actions: {
    requestRoll (definition: string): void {
      this.dicebagDefinition = definition
    },
    updateResult (rolledResult: RollResultDto): void {
      this.dicebagDefinition = ''
      this.totalRolled = rolledResult.total
      this.breakdown = rolledResult.rollBreakdown
    }
  }
})
