<script setup lang="ts">
import { Skill } from './SkillSet'
import SkillTable from '@/UI/components/Character/Skills/SkillTable.vue'
import { defineProps } from 'vue'

defineProps<{
  category: string,
  skills: Skill[]
}>()
</script>

<template>
  <v-expansion-panel
    :title="category"
  >
    <v-expansion-panel-text>
      <SkillTable :skills="skills" />
    </v-expansion-panel-text>
  </v-expansion-panel>
</template>
