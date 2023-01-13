<script setup lang="ts">
import { ref, computed } from 'vue'
import professionsData from './professions.json'
import ProfessionSelector from './ProfessionSelector.vue'
import ProfessionDisplay from './ProfessionDisplay.vue'
import { ProfessionData } from './ProfessionData'
import { ProfessionKey } from './ProfessionKey'

const professionKeys = ref(Object.keys(professionsData))
const selectedProfessionKey = ref<ProfessionKey | null>(null)

const selectedProfession = computed((): ProfessionData | null => {
  if (!selectedProfessionKey.value) {
    return null
  }
  return professionsData[selectedProfessionKey.value] ?? null
})
</script>
<template>
  <v-row>
    <v-col cols="4">
      <ProfessionSelector
        v-model="selectedProfessionKey"
        :options="professionKeys"
      />
    </v-col>
    <v-col cols="8">
      <ProfessionDisplay
        :profession="selectedProfession"
      />
    </v-col>
  </v-row>
</template>
