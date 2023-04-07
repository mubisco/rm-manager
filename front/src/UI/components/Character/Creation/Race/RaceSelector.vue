<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { FetchAllRacesNamesQueryHandler } from '@/Application/Profession/Race/Query/FetchAllRacesNamesQueryHandler'
import { FileRaceRepository } from '@/Infrastructure/Character/Race/Persistance/File/FileRaceRepository'
import type { RaceName } from '@/Domain/Character/Profession/Race/RaceName'
import { RaceCode } from '@/Domain/Character/Profession/Race/RaceCode'

const props = defineProps<{ modelValue: RaceCode | null }>()
const emit = defineEmits<{(eventName: 'update:modelValue', selectedRace: RaceCode): void }>()

const value = ref(props.modelValue ?? '')
const raceNames = ref<RaceName[]>([])

onMounted(async () => {
  const handler = new FetchAllRacesNamesQueryHandler(new FileRaceRepository())
  raceNames.value = await handler.handle()
})

const onValueUpdated = (event: string) => {
  emit('update:modelValue', event as RaceCode)
}

</script>
<template>
  <v-select
    v-model="value"
    label="Escoge raza"
    :items="raceNames"
    item-title="name"
    item-value="code"
    @update:model-value="onValueUpdated"
  />
</template>
