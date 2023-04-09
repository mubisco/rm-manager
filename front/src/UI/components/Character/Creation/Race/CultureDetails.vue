<script setup lang="ts">
import { watch, ref } from 'vue'
import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { CultureDto } from '@/Domain/Character/Culture/CultureDto'
import { FetchCultureByCodeQueryHandler } from '@/Application/Culture/Query/FetchCultureByCodeQueryHandler'
import { FileCultureRepository } from '@/Infrastructure/Character/Culture/Persistance/File/FileCultureRepository'
import { FetchCultureByCodeQuery } from '@/Application/Culture/Query/FetchCultureByCodeQuery'
import CustomMarkdown from '@/UI/components/Shared/CustomMarkdown.vue'
import CultureLanguageDisplay from './CultureLanguagesDisplay.vue'
import CultureSkillsTable from './CultureSkillsTable.vue'

const props = defineProps<{ selectedCulture: CultureCode }>()
const cultureData = ref<CultureDto | null>(null)

const loadRaceDetails = async () => {
  const handler = new FetchCultureByCodeQueryHandler(new FileCultureRepository())
  const query = new FetchCultureByCodeQuery(props.selectedCulture)
  cultureData.value = await handler.handle(query)
}

watch(() => props.selectedCulture, () => {
  loadRaceDetails()
})

</script>
<template>
  <div v-if="cultureData !== null">
    <h2 class="text-h5">
      {{ cultureData.name }}
    </h2>
    <v-row>
      <v-col cols="8">
        <CustomMarkdown :content="cultureData.description" />
        <p class="text-subtitle-2">
          {{ $t('character.culture.preferred-locations') }}
        </p>
        <CustomMarkdown :content="cultureData.preferredLocations" />
        <p class="text-subtitle-2">
          {{ $t('character.culture.clothing-decoration') }}
        </p>
        <CustomMarkdown :content="cultureData.clothingDecoration" />
        <p class="text-subtitle-2">
          {{ $t('character.culture.demeanor') }}
        </p>
        <CustomMarkdown :content="cultureData.demeanor" />
        <CultureLanguageDisplay :languages="cultureData.startingLanguages" />
      </v-col>
      <v-col cols="4">
        <CultureSkillsTable :skills="cultureData.skills" />
      </v-col>
    </v-row>
  </div>
</template>
