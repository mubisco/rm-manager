import { RollResultDto } from '@/Domain/DiceBag/RollResultDto'
import { defineStore } from 'pinia'

export const useDicebagStore = defineStore('dicebag', {
  state: () => ({
    totalRolled: 0,
    dicebagDefinition: '',
    treshold: 0,
    key: '',
    rollBreakdown: [] as number[]
  }),
  getters: {
    rolledValue: state => state.totalRolled,
    definition: state => state.dicebagDefinition,
    breakdown: state => state.rollBreakdown,
    getTreshold: state => state.treshold,
    rollKey: state => state.key
  },
  actions: {
    requestRoll (key: string, definition: string): void {
      this.key = key
      this.dicebagDefinition = definition
      this.treshold = 0
    },
    requestRollWithTreshold (key: string, definition: string, treshold: number): void {
      console.log(key)
      this.key = key as string
      this.dicebagDefinition = definition
      this.treshold = treshold
    },
    updateResult (rolledResult: RollResultDto): void {
      const parsedResult = JSON.parse(JSON.stringify(rolledResult))
      this.dicebagDefinition = ''
      this.totalRolled = rolledResult.total
      this.rollBreakdown = parsedResult.rollBreakdown
    }
  }
})
