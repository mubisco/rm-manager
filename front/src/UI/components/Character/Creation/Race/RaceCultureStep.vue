<script setup lang="ts">
import { ref } from 'vue'
import RaceSelectionFrame from './RaceSelectionFrame.vue'

const selectedRace = ref('')
// const selectedCulture = ref('')

</script>
<template>
  <v-row>
    <v-col cols="6">
      <RaceSelectionFrame
        :selected-race="selectedRace"
      />
    </v-col>
    <v-col cols="6">
      Cultures
    </v-col>
  </v-row>
</template>
