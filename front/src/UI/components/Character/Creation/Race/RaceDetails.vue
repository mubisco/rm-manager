<script setup lang="ts">
import { watch, ref } from 'vue'
import { RaceCode } from '@/Domain/Character/Race/RaceCode'
import { FetchRaceByCodeQueryHandler } from '@/Application/Race/Query/FetchRaceByCodeQueryHandler'
import { FetchRaceByCodeQuery } from '@/Application/Race/Query/FetchRaceByCodeQuery'
import CustomMarkdown from '@/UI/components/Shared/CustomMarkdown.vue'
import SpecialAbilitiesDisplay from './SpecialAbilitiesDisplay.vue'
import RacialStatsTable from './RacialStatsTable.vue'
import { RaceDto } from '@/Application/Race/Query/RaceDto'
import { FileRaceReadModel } from '@/Infrastructure/Character/Race/ReadModel/File/FileRaceReadModel'

const props = defineProps<{ selectedRace: RaceCode }>()
const raceData = ref<RaceDto | null>(null)

const loadRaceDetails = async () => {
  const handler = new FetchRaceByCodeQueryHandler(new FileRaceReadModel())
  const query = new FetchRaceByCodeQuery(props.selectedRace)
  raceData.value = await handler.handle(query)
}

watch(() => props.selectedRace, () => {
  loadRaceDetails()
})

</script>
<template>
  <div v-if="raceData !== null">
    <h2 class="text-h5">
      {{ raceData.name }}
    </h2>
    <RacialStatsTable
      :stat-modifiers="raceData.racialStatsModifiers"
      :endurance="raceData.endurance"
      :power-points="raceData.powerPoints"
      :resistance-bonuses="raceData.resistanceBonuses"
    />
    <p class="text-subtitle-2">
      {{ $t('character.races.demeanor') }}
    </p>
    <CustomMarkdown :content="raceData.demeanor" />
    <p class="text-subtitle-2">
      {{ $t('character.races.appearance') }}
    </p>
    <CustomMarkdown :content="raceData.appearance" />
    <p class="text-subtitle-2">
      {{ $t('character.races.lifespan') }}
    </p>
    <CustomMarkdown :content="raceData.lifespan" />
    <p class="text-subtitle-2">
      {{ $t('character.races.culture') }}
    </p>
    <CustomMarkdown :content="raceData.culture" />
    <SpecialAbilitiesDisplay
      :abilities="raceData.specialAbilities"
      :optional-abilities="raceData.selectableAbilities"
    />
  </div>
</template>
