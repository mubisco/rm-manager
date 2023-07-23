<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import ProfessionAbilities from './ProfessionAbilities.vue'
import ProfessionFavored from './ProfessionFavored.vue'
import { FetchProfessionByCodeQuery } from '@/Application/Profession/Query/FetchProfessionByCodeQuery'
import { ProfessionDto } from '@/Application/Profession/Query/ProfessionDto'
import FavoredCategoriesTable from './FavoredCategoriesTable.vue'
import { FetchProfessionByCodeQueryHandlerProvider } from '@/Infrastructure/Character/Provider/FetchProfessionByCodeQueryHandlerProvider'

const props = defineProps<{ professionKey: string }>()
const professionData = ref<ProfessionDto | null>(null)

const loadProfessionDetails = async () => {
  const provider = new FetchProfessionByCodeQueryHandlerProvider()
  const handler = provider.provide()
  const query = new FetchProfessionByCodeQuery(props.professionKey)
  professionData.value = await handler.handle(query)
}

onMounted(() => {
  loadProfessionDetails()
})

watch(() => props.professionKey, () => {
  loadProfessionDetails()
})

</script>
<template>
  <div v-if="professionData !== null">
    <div>
      <p class="body-1">
        {{ professionData.description }}
      </p>
      <v-row>
        <v-col cols="8">
          <ProfessionFavored
            :stats="professionData.keyStats"
          />
          <ProfessionAbilities
            :abilities="professionData.professionalAbilities"
            :notes="professionData.notes"
          />
        </v-col>
        <v-col cols="4">
          <FavoredCategoriesTable
            :categories="professionData.fixedCategories"
            :free-categories="professionData.freeCategories"
          />
        </v-col>
      </v-row>
    </div>
  </div>
</template>
