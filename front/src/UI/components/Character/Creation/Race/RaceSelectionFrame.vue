<script setup lang="ts">
import { ref } from 'vue'
import RaceSelector from './RaceSelector.vue'
import RaceDetails from './RaceDetails.vue'
import { RaceCode } from '@/Domain/Character/Profession/Race/RaceCode'

const props = defineProps<{ selectedRace: string }>()

const currentSelectedRace = ref<RaceCode | null>(props.selectedRace as RaceCode ?? null)

</script>
<template>
  <RaceSelector
    v-model="currentSelectedRace"
  />
  <RaceDetails
    v-if="currentSelectedRace"
    :selected-race="currentSelectedRace"
  />
  <v-alert
    v-else
    type="info"
    variant="tonal"
  >
    <p>Please select a race to view details</p>
  </v-alert>
</template>
