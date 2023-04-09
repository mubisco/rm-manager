<script setup lang="ts">
import { ref } from 'vue'
import { Stat } from '@/Domain/Character/Stat/Stat'
import { StatCode } from '@/Domain/Character/Stat/StatCode'
import StatPointInput from './StatPointInput.vue'

defineProps<{ availablePoints: number }>()

const emits = defineEmits<{(eventName: 'points:updated', amount: number): number}>()

const stats = ref<{ [code: string]: Stat | null }>({
  ST: Stat.fromCode(StatCode.STRENGTH),
  CO: Stat.fromCode(StatCode.CONSTITUTION),
  AG: Stat.fromCode(StatCode.AGILITY),
  QU: Stat.fromCode(StatCode.QUICKNESS),
  SD: Stat.fromCode(StatCode.SELF_DISCIPLINE),
  RE: Stat.fromCode(StatCode.REASONING),
  IN: Stat.fromCode(StatCode.INSIGHT),
  PR: Stat.fromCode(StatCode.PRESENCE)
})
const onStatIncreased = (code: string, amount: number): void => {
  const stat = stats.value[code]
  const updatedStat = stat?.increase(amount)
  updateStat(updatedStat, code)
  emits('points:updated', -amount)
}
const onStatDecreased = (code: string, amount: number): void => {
  const stat = stats.value[code]
  const updatedStat = stat?.reduce(amount)
  updateStat(updatedStat, code)
  emits('points:updated', amount)
}

const updateStat = (stat: Stat | undefined, code: string): void => {
  if (!stat) {
    return
  }
  stats.value[code] = stat
}
</script>
<template>
  <v-table>
    <thead>
      <tr>
        <th>{{ $t('character.stats-step.stats-table.name') }}</th>
        <th>{{ $t('character.stats-step.stats-table.points-spent') }}</th>
        <th>{{ $t('character.stats-step.stats-table.value') }}</th>
        <th>{{ $t('character.stats-step.stats-table.bonus') }}</th>
        <th>{{ $t('character.stats-step.stats-table.dp') }}</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(stat, code) in stats"
        :key="code"
      >
        <td>{{ $t('character.stats.' + code) }}</td>
        <td>
          <StatPointInput
            :current-stat-value="stat.spentPoints()"
            :available-points="availablePoints"
            @stat:increase="onStatIncreased(code as string, $event)"
            @stat:decrease="onStatDecreased(code as string, $event)"
          />
        </td>
        <td>
          {{ stat.rawValue() }}
        </td>
        <td>
          {{ stat.bonus() }}
        </td>
        <td>
          {{ stat.developmentPoints() }}
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
