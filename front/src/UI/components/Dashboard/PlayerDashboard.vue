<script setup lang="ts">
import GamesTable from '@/UI/components/Dashboard/GamesTable.vue'
import CharacterTable from '@/UI/components/Dashboard/CharacterTable.vue'
</script>

<template>
  <v-row>
    <v-col md="6">
      <CharacterTable />
    </v-col>
    <v-col md="6">
      <GamesTable />
    </v-col>
  </v-row>
</template>
