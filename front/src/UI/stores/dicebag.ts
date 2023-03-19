import { defineStore } from 'pinia'

export const useDicebagStore = defineStore('dicebag', {
  state: () => ({
    totalRolled: 0,
    dicebagDefinition: ''
  }),
  getters: {
    rolledValue: state => state.totalRolled,
    definition: state => state.dicebagDefinition
  },
  actions: {
    requestRoll (definition: string): void {
      this.dicebagDefinition = definition
    },
    doRoll (totalRolled: number): void {
      this.dicebagDefinition = ''
      this.totalRolled = totalRolled
    }
  }
})
