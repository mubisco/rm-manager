<script setup lang="ts">
import { SkillSet } from './SkillSet.ts'
import CategorySkillList from './CategorySkillList.vue'
import { defineProps } from 'vue'

defineProps<{
  skills: SkillSet
}>()
</script>

<template>
  <v-card
    flat
    border
  >
    <v-card-text>
      <v-expansion-panels>
        <CategorySkillList
          v-for="(categorySkills, key) in skills"
          :key="key"
          :category="key"
          :skills="categorySkills"
        />
      </v-expansion-panels>
    </v-card-text>
  </v-card>
</template>
