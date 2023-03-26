<script setup lang="ts">

defineProps<{ currentStatValue: number, availablePoints: number }>()
const emits = defineEmits<{(eventName: 'stat:increase', amount: number): number,
   (eventName: 'stat:decrease', amount: number): number
}>()

const increasePoints = (quantity: number): void => {
  emits('stat:increase', quantity)
}
const reducePoints = (quantity: number): void => {
  emits('stat:decrease', quantity)
}
</script>
<template>
  <div class="d-flex align-center">
    <v-btn
      prepend-icon="mdi-chevron-double-left"
      variant="tonal"
      size="small"
      :disabled="currentStatValue < 5"
      @click="reducePoints(5)"
    >
      5
    </v-btn>
    <v-btn
      prepend-icon="mdi-chevron-left"
      variant="tonal"
      color="primary"
      class="ml-2"
      size="small"
      :disabled="currentStatValue === 0"
      @click="reducePoints(1)"
    >
      1
    </v-btn>
    <v-sheet
      class="text-center mr-2 ml-2 pa-2"
      border
      rounded
      width="50"
    >
      {{ currentStatValue }}
    </v-sheet>
    <v-btn
      append-icon="mdi-chevron-right"
      variant="tonal"
      class="mr-2"
      size="small"
      :disabled="currentStatValue === 165 || availablePoints < 1"
      @click="increasePoints(1)"
    >
      1
    </v-btn>
    <v-btn
      append-icon="mdi-chevron-double-right"
      variant="tonal"
      size="small"
      :disabled="currentStatValue > 160 || availablePoints < 5"
      @click="increasePoints(5)"
    >
      5
    </v-btn>
  </div>
</template>
