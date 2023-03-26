<script setup lang="ts">
import { ref } from 'vue'
import StatsGenerationSelector from './StatsGenerationSelector.vue'
import RollStatsAssignment from './RollStatsAssignment.vue'
import FixedPointsStatsAssignment from './FixedPointsStatsAssignment.vue'
import PointsWithRollStatsAssignment from './PointsWithRollStatsAssignment.vue'

const selectedMethod = ref('POINTS_FIXED')
const availablePoints = ref(50)
</script>
<template>
  <div>
    <StatsGenerationSelector
      v-model:method="selectedMethod"
      v-model:points="availablePoints"
    />
    <RollStatsAssignment
      v-if="selectedMethod === 'ROLL'"
    />
    <FixedPointsStatsAssignment
      v-if="selectedMethod === 'POINTS_FIXED'"
    />
    <PointsWithRollStatsAssignment
      v-if="selectedMethod === 'POINTS_WITH_ROLL'"
      :available-points="availablePoints"
    />
  </div>
</template>
