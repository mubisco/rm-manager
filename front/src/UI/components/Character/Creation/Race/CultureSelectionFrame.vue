<script setup lang="ts">
import { ref } from 'vue'
import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import CultureSelector from './CultureSelector.vue'
import CultureDetails from './CultureDetails.vue'

const props = defineProps<{ selectedCulture: string }>()

const currentSelectedCulture = ref<CultureCode | null>(props.selectedCulture as CultureCode ?? null)

</script>
<template>
  <CultureSelector v-model="currentSelectedCulture" />
  <CultureDetails
    v-if="currentSelectedCulture"
    :selected-culture="currentSelectedCulture"
  />
  <v-alert
    v-else
    type="info"
    variant="tonal"
  >
    <p>{{ $t('character.culture.culture-unselected') }}</p>
  </v-alert>
</template>
