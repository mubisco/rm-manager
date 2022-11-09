<script setup lang="ts">
import { ref } from 'vue'

const values = ref([
  { title: 'Visión Oscuridad', subtitle: '30 m noche estrellada, 152 luna llena' },
  { title: 'Musculatura densa', subtitle: '+5 BD/BO' },
  { title: 'Sentido Pétreo', subtitle: 'Percepción normal en Piedra' },
  { title: 'Adiestramiento con Escudos', subtitle: '' },
  { title: 'Reflejos Relámpago', subtitle: '+5 iniciativa' },
  { title: 'Instinto Defensivo', subtitle: '+20 BD estando prevenido, +10 si no' }
])
</script>

<template>
  <v-card
    flat
    border
    :title="$t('character.sections.talents.title')"
  >
    <v-card-text>
      <v-list
        lines="one"
      >
        <v-list-item
          v-for="(item, index) in values"
          :key="index"
          :title="item.title"
          :subtitle="item.subtitle"
        />
      </v-list>
    </v-card-text>
  </v-card>
</template>
