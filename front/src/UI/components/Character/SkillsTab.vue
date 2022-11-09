<script setup lang="ts">
import SkillList from '@/UI/components/Character/Skills/SkillList.vue'
import { ref } from 'vue'

const skillList = ref({
  skills: {
    artistic: [
      { name: 'acting', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
      { name: 'dancing', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
      { name: 'mimicry', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
      { name: 'play instrument', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
    ],
    athletic: [
      { name: 'acrobatics', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
      { name: 'climbing', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
      { name: 'contortions', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
    ],
    combat: [
    ],
    general: [
    ],
    influence: [
    ],
    mystical: [
    ],
    outdoor: [
    ],
    physical: [
    ],
    subterfuge: [
    ]
  },
  spells: {}
})
</script>

<template>
  <v-row>
    <v-col cols="6">
      <SkillList :skills="skillList.skills" />
    </v-col>
    <v-col cols="6">
    </v-col>
  </v-row>
</template>
