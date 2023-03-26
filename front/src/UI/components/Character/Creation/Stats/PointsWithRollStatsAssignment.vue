<script setup lang="ts">
import { ref, watch } from 'vue'
import PointsStatsTable from './PointsStatsTable.vue'
import AvailablePoints from './AvailablePoints.vue'

const props = defineProps<{ availablePoints: number }>()

const currentPoints = ref(0)

watch(() => props.availablePoints, () => {
  currentPoints.value = props.availablePoints + 500
})

const onPointsUpdated = (amount: number): void => {
  currentPoints.value += amount
}
</script>
<template>
  <v-row>
    <v-col cols="2">
      <v-sheet
        class="text-center pa-2"
        border
        rounded
      >
        <AvailablePoints :available-points="currentPoints" />
      </v-sheet>
    </v-col>
    <v-col cols="10">
      <PointsStatsTable
        v-if="currentPoints !== 0"
        :available-points="currentPoints"
        @points:updated="onPointsUpdated"
      />
    </v-col>
  </v-row>
</template>
