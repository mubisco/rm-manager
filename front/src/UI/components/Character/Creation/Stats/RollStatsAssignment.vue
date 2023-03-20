<script setup lang="ts">
import { watch, ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useDicebagStore } from '@/UI/stores/dicebag'
import { v4 as uuidv4 } from 'uuid'
import RollBoard from './RollBoard.vue'
import StatsTable from './StatsTable.vue'

const dicebagStore = useDicebagStore()
const { totalRolled } = storeToRefs(dicebagStore)
const rollKey = ref(uuidv4())

watch(totalRolled, () => {
  if (dicebagStore.rollKey === rollKey.value) {
    rolledResults.value = [...dicebagStore.breakdown]
  }
})
const rolledResults = ref<number[]>([])
const assignedRollsIndex = ref<number[]>([])

const onRollRemoved = (rollIndex: number): void => {
  const filteredRollsIndex = assignedRollsIndex.value.filter(index => index !== rollIndex)
  assignedRollsIndex.value = filteredRollsIndex
}

const onRollAssigned = (rollIndex: number): void => {
  const assignedRollsIndexCopy = [...assignedRollsIndex.value]
  assignedRollsIndexCopy.push(rollIndex)
  assignedRollsIndex.value = assignedRollsIndexCopy
}

</script>
<template>
  <div>
    <v-row>
      <v-col cols="2">
        <RollBoard
          :rolled-results="rolledResults"
          :assigned-rolls-index="assignedRollsIndex"
        />
        <v-btn
          block
          prepend-icon="mdi-dice-d10-outline"
          class="mr-4"
          @click="dicebagStore.requestRollWithTreshold(rollKey, '8d100', 40)"
        >
          Roll 8D100
        </v-btn>
      </v-col>
      <v-col cols="10">
        <StatsTable
          @roll:removed="onRollRemoved"
          @roll:assigned="onRollAssigned"
        />
      </v-col>
    </v-row>
  </div>
</template>
