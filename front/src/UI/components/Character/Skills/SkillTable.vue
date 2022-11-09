<script setup lang="ts">
import { Skill } from './SkillSet'
import SkillRow from '@/UI/components/Character/Skills/SkillRow.vue'
import { defineProps } from 'vue'

defineProps<{
  skills: Skill[]
}>()
</script>

<template>
  <v-table density="compact">
    <thead>
      <tr>
        <th>Nombre</th>
        <th class="text-right">
          Coste
        </th>
        <th class="text-right">
          Rangos
        </th>
        <th class="text-right">
          Bonus
        </th>
        <th class="text-right">
          Car.
        </th>
        <th class="text-right">
          Esp.
        </th>
        <th class="text-right">
          Total
        </th>
      </tr>
    </thead>
    <tbody>
      <SkillRow
        v-for="(skill, index) in skills"
        :key="index"
        :skill="skill"
      />
    </tbody>
  </v-table>
</template>
