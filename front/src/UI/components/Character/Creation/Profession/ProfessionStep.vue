<script setup lang="ts">
import { ref } from 'vue'
import ProfessionSelector from './ProfessionSelector.vue'
import ProfessionDisplay from './ProfessionDisplay.vue'
import { ProfessionCode } from '@/Domain/Character/Profession/ProfessionCode'

const selectedProfessionKey = ref<ProfessionCode | null>(null)

</script>
<template>
  <v-row>
    <v-col cols="4">
      <ProfessionSelector
        v-model="selectedProfessionKey"
      />
    </v-col>
    <v-col cols="8">
      <v-alert
        v-if="selectedProfessionKey === null"
        type="info"
        variant="tonal"
      >
        {{ $t('character.profession.no-selected') }}
      </v-alert>
      <ProfessionDisplay
        v-else
        :profession-key="selectedProfessionKey"
      />
    </v-col>
  </v-row>
</template>
