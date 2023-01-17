<script setup lang="ts">
import { ref } from 'vue'

const selectedMethod = ref('POINTS_FIXED')
const availablePoints = ref(0)
</script>
<template>
  <div>
    <p>{{ selectedMethod }} - {{ availablePoints }}</p>
  </div>
</template>
