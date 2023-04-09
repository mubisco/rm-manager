<script setup lang="ts">
import { ref } from 'vue'
import RaceSelectionFrame from './RaceSelectionFrame.vue'
import CultureSelectionFrame from './CultureSelectionFrame.vue'

const selectedRace = ref('')
const selectedCulture = ref('')

</script>
<template>
  <v-row>
    <v-col cols="6">
      <RaceSelectionFrame
        :selected-race="selectedRace"
      />
    </v-col>
    <v-col cols="6">
      <CultureSelectionFrame
        :selected-culture="selectedCulture"
      />
    </v-col>
  </v-row>
</template>
