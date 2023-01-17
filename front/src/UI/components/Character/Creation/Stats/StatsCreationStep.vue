<script setup lang="ts">
import { ref } from 'vue'
import StatsGenerationSelector from './StatsGenerationSelector.vue'

const selectedMethod = ref('POINTS_FIXED')
const availablePoints = ref(0)
</script>
<template>
  <div>
    <StatsGenerationSelector
      v-model:method="selectedMethod"
      v-model:points="availablePoints"
    />
    <p>{{ selectedMethod }} - {{ availablePoints }}</p>
  </div>
</template>
