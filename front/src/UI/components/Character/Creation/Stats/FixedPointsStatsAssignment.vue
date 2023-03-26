<script setup lang="ts">
import { ref } from 'vue'
import PointsStatsTable from './PointsStatsTable.vue'
import AvailablePoints from './AvailablePoints.vue'

const availablePoints = ref(550)
const onPointsUpdated = (amount: number): void => {
  availablePoints.value += amount
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
        <AvailablePoints :available-points="availablePoints" />
      </v-sheet>
    </v-col>
    <v-col cols="10">
      <PointsStatsTable
        :available-points="availablePoints"
        @points:updated="onPointsUpdated"
      />
    </v-col>
  </v-row>
</template>
