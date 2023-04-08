<script setup lang="ts">
import { watch, ref } from 'vue'
import { RaceCode } from '@/Domain/Character/Profession/Race/RaceCode'
import { RaceDto } from '@/Domain/Character/Profession/Race/RaceDto'
import { FetchRaceByCodeQueryHandler } from '@/Application/Profession/Race/Query/FetchRaceByCodeQueryHandler'
import { FetchRaceByCodeQuery } from '@/Application/Profession/Race/Query/FetchRaceByCodeQuery'
import { FileRaceRepository } from '@/Infrastructure/Character/Race/Persistance/File/FileRaceRepository'
import CustomMarkdown from '@/UI/components/Shared/CustomMarkdown.vue'
import SpecialAbilitiesDisplay from './SpecialAbilitiesDisplay.vue'
import RacialStatsTable from './RacialStatsTable.vue'

const props = defineProps<{ selectedRace: RaceCode }>()
const raceData = ref<RaceDto | null>(null)

const loadRaceDetails = async () => {
  const handler = new FetchRaceByCodeQueryHandler(new FileRaceRepository())
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
