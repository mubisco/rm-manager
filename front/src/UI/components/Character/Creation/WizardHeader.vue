<script setup lang="ts">
import { defineProps, ref } from 'vue'

defineProps<{ currentStep: number }>()
const steps = ref([
  { label: 'Profesión' },
  { label: 'Características' },
  { label: 'Raza & Cultura' },
  { label: 'Habilidates & Talentos' },
  { label: 'Equipo' },
  { label: 'Detalles Finales' }
])

const calculateSize = (index: number, currentIndex: number): string => {
  if (index === currentIndex) {
    return 'large'
  }
  return (index > currentIndex) ? 'small' : 'default'
}
const calculateDotColor = (index: number, currentIndex: number): string => {
  if (index === currentIndex) {
    return 'primary'
  }
  return (index > currentIndex) ? 'grey' : 'black'
}
</script>
<template>
  <v-timeline
    side="start"
    direction="horizontal"
  >
    <v-timeline-item
      v-for="(step, index) in steps"
      :key="index"
      :size="calculateSize(currentStep, index)"
      :dot-color="calculateDotColor(currentStep, index)"
    >
      <template #icon>
        <span class="text-white">{{ index + 1 }}</span>
      </template>
      <div class="text-h6">
        {{ step.label }}
      </div>
    </v-timeline-item>
  </v-timeline>
</template>
