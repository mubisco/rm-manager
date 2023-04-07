<script setup lang="ts">
import { RaceCode } from '@/Domain/Character/Profession/Race/RaceCode'

defineProps<{ selectedRace: RaceCode | null }>()

</script>
<template>
  <p>{{ selectedRace }}</p>
</template>
