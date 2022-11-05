<script setup lang="ts">
const items = [
  {
    name: 'Chindasvinto',
    system: 'HARP',
    createdAt: '2021-01-21',
    updatedAt: '2021-01-21',
    characterStatus: 'FREE',
    level: 7
  },
  {
    name: 'Chindasvinto II',
    system: 'HARP',
    createdAt: '2021-05-12',
    updatedAt: '2022-01-01',
    characterStatus: 'IN_GAME',
    level: 5
  }
]
const headers = [
  {
    text: 'Character name',
    value: 'name'
  },
  {
    text: 'System',
    value: 'system'
  },
  {
    text: 'Level',
    value: 'level'
  },
  {
    text: 'Creation date',
    value: 'createdAt'
  },
  {
    text: 'Last update',
    value: 'updatedAt'
  },
  {
    text: 'Status',
    value: 'characterStatus'
  }
]
</script>

<template>
  <v-card
    title="My Characters"
  >
    <v-data-table
      v-cy:mypc-table
      :headers="headers"
      :items="items"
      :items-per-page="5"
      class="elevation-1"
    />
  </v-card>
</template>
