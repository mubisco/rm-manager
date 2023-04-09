<script setup lang="ts">
import { CultureSkillSet } from '@/Domain/Character/Culture/CultureSkillSet'

defineProps<{ skills: CultureSkillSet }>()
</script>
<template>
  <p class="text-subtitle-2">
    {{ $t('character.culture.skill-table.title') }}
  </p>
  <v-table
    density="compact"
  >
    <thead>
      <tr>
        <th>
          {{ $t('character.culture.skill-table.skill') }}
        </th>
        <th class="text-right">
          {{ $t('character.culture.skill-table.ranks') }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(skill, key) in skills"
        :key="key"
      >
        <td>{{ $t('character.skills.abilities.' + key) }}</td>
        <td class="text-right">
          {{ skill }}
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
