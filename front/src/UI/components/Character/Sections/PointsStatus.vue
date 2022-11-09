<script setup lang="ts">
import PointCount from '@/UI/components/Character/Sections/PointCount.vue'
import { ref } from 'vue'

const values = ref({
  currentHp: 50,
  maxHp: 50,
  currentPp: 30,
  maxPp: 30
})
</script>

<template>
  <v-card
    flat
    border
  >
    <v-card-text>
      <PointCount
        :title="$t('character.sections.points.hp')"
        :max="values.maxHp"
        :current="values.currentHp"
      />
      <PointCount
        :title="$t('character.sections.points.pp')"
        :max="values.maxPp"
        :current="values.currentPp"
      />
    </v-card-text>
  </v-card>
</template>
