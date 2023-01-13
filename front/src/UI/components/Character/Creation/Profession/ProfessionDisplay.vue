<script setup lang="ts">
import { defineProps } from 'vue'
import { ProfessionData } from './ProfessionData'
import ProfessionAbilities from './ProfessionAbilities.vue'
import ProfessionFavored from './ProfessionFavored.vue'

defineProps<{ profession: ProfessionData | null }>()

</script>
<template>
  <div>
    <v-alert
      v-if="profession === null"
      type="info"
    >
      {{ $t('character.profession.no-selected') }}
    </v-alert>
    <div v-if="profession !== null">
      <h2>Descripción</h2>
      <p>{{ profession.description }}</p>
      <ProfessionFavored
        :stats="profession.keyStats"
        :categories="profession.fixedCategories"
        :free-categories="profession.freeCategories"
      />
      <ProfessionAbilities
        :abilities="profession.professionalAbilities"
        :notes="profession.notes"
      />
    </div>
  </div>
</template>
