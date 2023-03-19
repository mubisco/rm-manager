import { RollResultDto } from '@/Domain/DiceBag/RollResultDto'
import { defineStore } from 'pinia'

export const useDicebagStore = defineStore('dicebag', {
  state: () => ({
    totalRolled: 0,
    dicebagDefinition: '',
    rollBreakdown: [] as number[]
  }),
  getters: {
    rolledValue: state => state.totalRolled,
    definition: state => state.dicebagDefinition,
    breakdown: state => state.rollBreakdown
  },
  actions: {
    requestRoll (definition: string): void {
      this.dicebagDefinition = definition
    },
    updateResult (rolledResult: RollResultDto): void {
      const parsedResult = JSON.parse(JSON.stringify(rolledResult))
      this.dicebagDefinition = ''
      this.totalRolled = rolledResult.total
      this.rollBreakdown = parsedResult.rollBreakdown
    }
  }
})
