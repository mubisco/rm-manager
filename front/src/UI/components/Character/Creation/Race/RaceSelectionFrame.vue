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
  <RaceDetails :selected-race="currentSelectedRace" />
</template>
