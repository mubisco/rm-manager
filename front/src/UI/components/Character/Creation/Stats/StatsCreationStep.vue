<script setup lang="ts">
import { ref } from 'vue'
import StatsGenerationSelector from './StatsGenerationSelector.vue'
import StatsAssignment from './StatsAssignment.vue'

const selectedMethod = ref('POINTS_FIXED')
const availablePoints = ref(0)
</script>
<template>
  <div>
    <StatsGenerationSelector
      v-model:method="selectedMethod"
      v-model:points="availablePoints"
    />
    <StatsAssignment
      :selected-method="selectedMethod"
      :available-points="availablePoints"
    />
  </div>
</template>
