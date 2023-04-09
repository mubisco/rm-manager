<script setup lang="ts">
import { ref } from 'vue'
import { Stat } from '@/Domain/Character/Stat/Stat'
import { StatCode } from '@/Domain/Character/Stat/StatCode'

const assignedRolls = ref<{ originalIndex: number; roll: number }[]>([])

const emit = defineEmits<{(eventName: 'roll:assigned', originalIndex: number): void,
  (eventName: 'roll:removed', originalIndex: number): void
}>()

const drop = (event: DragEvent, rowIndex: number, code: string): void => {
  if (event.dataTransfer === null) {
    return
  }
  const index = parseInt(event.dataTransfer.getData('index'), 10)
  const value = parseInt(event.dataTransfer.getData('value'), 10)
  if (assignedRolls.value[rowIndex]) {
    emit('roll:removed', assignedRolls.value[rowIndex].originalIndex)
  }
  assignedRolls.value[rowIndex] = { originalIndex: index, roll: value }
  stats.value[code] = Stat.fromValue(code as StatCode, value)
  emit('roll:assigned', index)
}

const removeRoll = (indexToRemove: number, code: string): void => {
  const assignedRollsCopy = [...assignedRolls.value]
  const originalIndexRemoved = assignedRollsCopy[indexToRemove].originalIndex
  delete assignedRollsCopy[indexToRemove]
  assignedRolls.value = assignedRollsCopy
  stats.value[code] = null
  emit('roll:removed', originalIndexRemoved)
}

const statsCodes = ref(['ST', 'CO', 'AG', 'QU', 'SD', 'RE', 'IN', 'PR'])
const stats = ref<{ [code: string]: Stat | null }>({
  ST: null,
  CO: null,
  AG: null,
  QU: null,
  SD: null,
  RE: null,
  IN: null,
  PR: null
})

const parseStatBonusFromCode = (code: string): number | string => {
  if (stats.value === null) {
    return '-'
  }
  const currentStat = stats.value[code]
  if (currentStat === null) {
    return '-'
  }
  return currentStat.bonus()
}

const parseStatDevelopmentPointsFromCode = (code: string): number | string => {
  if (stats.value === null) {
    return '-'
  }
  const currentStat = stats.value[code]
  if (currentStat === null) {
    return '-'
  }
  return currentStat.developmentPoints()
}

</script>
<template>
  <v-table>
    <thead>
      <tr>
        <th>{{ $t('character.stats-step.stats-table.name') }}</th>
        <th>{{ $t('character.stats-step.stats-table.value') }}</th>
        <th>{{ $t('character.stats-step.stats-table.bonus') }}</th>
        <th>{{ $t('character.stats-step.stats-table.dp') }}</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(code, index) in statsCodes"
        :key="code"
        @dragover.prevent
        @drop="drop($event, index, code)"
      >
        <td>{{ $t('character.stats.' + code) }}</td>
        <td>
          <v-chip
            v-if="typeof assignedRolls[index] !== 'undefined'"
            variant="elevated"
            color="primary"
            closable
            @click:close="removeRoll(index, code)"
          >
            {{ assignedRolls[index].roll }}
          </v-chip>
        </td>
        <td>
          {{ parseStatBonusFromCode(code) }}
        </td>
        <td>
          {{ parseStatDevelopmentPointsFromCode(code) }}
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
