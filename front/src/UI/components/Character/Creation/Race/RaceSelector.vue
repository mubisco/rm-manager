<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { FetchAllRacesNamesQueryHandler } from '@/Application/Race/Query/FetchAllRacesNamesQueryHandler'
import { RaceCode } from '@/Domain/Character/Race/RaceCode'
import { FileRaceReadModel } from '@/Infrastructure/Character/Race/ReadModel/File/FileRaceReadModel'
import { RaceName } from '@/Application/Race/Query/RaceName'

const props = defineProps<{ modelValue: RaceCode | null }>()
const emit = defineEmits<{(eventName: 'update:modelValue', selectedRace: RaceCode): void }>()

const value = ref(props.modelValue ?? '')
const raceNames = ref<RaceName[]>([])

onMounted(async () => {
  const handler = new FetchAllRacesNamesQueryHandler(new FileRaceReadModel())
  raceNames.value = await handler.handle()
})

const onValueUpdated = (event: string) => {
  emit('update:modelValue', event as RaceCode)
}

</script>
<template>
  <v-select
    v-model="value"
    :label="$t('character.races.select-race')"
    :items="raceNames"
    item-title="name"
    item-value="code"
    @update:model-value="onValueUpdated"
  />
</template>
