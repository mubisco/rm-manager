<script setup lang="ts">
import { Skill } from './SkillSet'
import { computed, defineProps } from 'vue'

const props = defineProps<{
  skill: Skill
}>()

const rankBonus = computed((): number => {
  if (props.skill.ranks === 0) {
    return -25
  }
  return props.skill.ranks * 5
})

const total = computed((): number => {
  return rankBonus.value + props.skill.statBonus + props.skill.specialBonus
})

const skillName = computed((): string => {
  let name = ''
  if (props.skill.subskill) {
    name += ' (' + props.skill.subskill + ')'
  }
  return props.skill.name + name
})
</script>

<template>
  <tr>
    <td>
      {{ skillName }}
    </td>
    <td class="text-right">
      {{ skill.cost }}
    </td>
    <td class="text-right">
      {{ skill.ranks }}
    </td>
    <td class="text-right">
      {{ rankBonus }}
    </td>
    <td class="text-right">
      {{ skill.statBonus }}
    </td>
    <td class="text-right">
      {{ skill.specialBonus }}
    </td>
    <td class="text-right">
      {{ total }}
    </td>
  </tr>
</template>
