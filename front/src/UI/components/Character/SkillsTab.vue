<script setup lang="ts">
import SkillList from '@/UI/components/Character/Skills/SkillList.vue'
import { SkillSet } from '@/UI/components/Character/Skills/SkillSet'

import { ref, computed } from 'vue'

const skillSet = ref({
  artistic: [
    { code: 'acting', name: 'Actuar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'dancing', name: 'Bailar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'mimicry', name: 'Mímica', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
    { code: 'play_instrument', name: 'Tocar Instrumento', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ],
  athletic: [
    { code: 'acrobatics', name: 'Acrobacias', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'climbing', name: 'Escalar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'contorsionism', name: 'Escapismo', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ],
  combat: [
    { code: 'acting', name: 'Actuar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'dancing', name: 'Bailar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'mimicry', name: 'Mímica', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
    { code: 'play_instrument', name: 'Tocar Instrumento', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ],
  general: [
    { code: 'acting', name: 'Actuar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'dancing', name: 'Bailar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'mimicry', name: 'Mímica', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
    { code: 'play_instrument', name: 'Tocar Instrumento', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ],
  influence: [
    { code: 'acting', name: 'Actuar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'dancing', name: 'Bailar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'mimicry', name: 'Mímica', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
    { code: 'play_instrument', name: 'Tocar Instrumento', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ],
  mystical: [
    { code: 'acting', name: 'Actuar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'dancing', name: 'Bailar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'mimicry', name: 'Mímica', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
    { code: 'play_instrument', name: 'Tocar Instrumento', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ],
  outdoor: [
    { code: 'acting', name: 'Actuar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'dancing', name: 'Bailar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'mimicry', name: 'Mímica', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
    { code: 'play_instrument', name: 'Tocar Instrumento', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ],
  physical: [
    { code: 'acting', name: 'Actuar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'dancing', name: 'Bailar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'mimicry', name: 'Mímica', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
    { code: 'play_instrument', name: 'Tocar Instrumento', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ],
  subterfuge: [
    { code: 'acting', name: 'Actuar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'dancing', name: 'Bailar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'mimicry', name: 'Mímica', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
    { code: 'play_instrument', name: 'Tocar Instrumento', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ],
  spells: [
    { code: 'acting', name: 'Actuar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'dancing', name: 'Bailar', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 },
    { code: 'mimicry', name: 'Mímica', cost: 2, ranks: 0, statBonus: 30, specialBonus: 0 },
    { code: 'play_instrument', name: 'Tocar Instrumento', subskill: 'Flute', cost: 2, ranks: 3, statBonus: 30, specialBonus: 0 }
  ]
})

const categories = computed((): string[] => {
  return Object.keys(skillSet.value)
})

const extractSkillset = (categories: string[]): SkillSet => {
  const splittedSkillSet: SkillSet = {}
  for (const key of categories) {
    splittedSkillSet[key] = skillSet.value[key]
  }
  return splittedSkillSet
}

const firstColumnSkills = computed((): SkillSet => {
  const selectedCategories = categories.value.slice(0, categories.value.length / 2)
  return extractSkillset(selectedCategories)
})
const secondColumnSkills = computed((): SkillSet => {
  const selectedCategories = categories.value.slice(categories.value.length / 2)
  return extractSkillset(selectedCategories)
})
</script>

<template>
  <v-row>
    <v-col cols="6">
      <SkillList :skills="firstColumnSkills" />
    </v-col>
    <v-col cols="6">
      <SkillList :skills="secondColumnSkills" />
    </v-col>
  </v-row>
</template>
