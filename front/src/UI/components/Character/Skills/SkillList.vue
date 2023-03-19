<script setup lang="ts">
import { SkillSet } from './SkillSet'
import SkillTable from '@/UI/components/Character/Skills/SkillTable.vue'
import { ref, watch } from 'vue'

const props = defineProps<{
  skills: SkillSet
}>()
const panelModel = ref(Object.keys(props.skills))

watch(() => props.skills, (newSkills: SkillSet) => {
  panelModel.value = Object.keys(newSkills)
})
</script>

<template>
  <v-expansion-panels
    v-model="panelModel"
    variant="accordion"
    multiple
  >
    <v-expansion-panel
      v-for="(categorySkills, key) in skills"
      :key="key"
      :value="key"
      :title="$t('character.skills.categories.' + key)"
      :category="key + ''"
    >
      <v-expansion-panel-text>
        <SkillTable :skills="categorySkills" />
      </v-expansion-panel-text>
    </v-expansion-panel>
  </v-expansion-panels>
</template>
