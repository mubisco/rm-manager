<script setup lang="ts">
import ProfessionStep from '@/UI/components/Character/Creation/Profession/ProfessionStep.vue'
import StatsCreationStep from '@/UI/components/Character/Creation/Stats/StatsCreationStep.vue'
import RaceCultureStep from '@/UI/components/Character/Creation/Race/RaceCultureStep.vue'
import SkillsSelector from '@/UI/components/Character/Creation/Skills/SkillsSelector.vue'
import EquipmentSelector from '@/UI/components/Character/Creation/EquipmentSelector.vue'
import FinalTouches from '@/UI/components/Character/Creation/FinalTouches.vue'

defineProps<{ currentStep: number }>()
</script>
<template>
  <div>
    <v-fade-transition>
      <ProfessionStep v-if="currentStep === 0" />
    </v-fade-transition>
    <v-fade-transition>
      <StatsCreationStep v-if="currentStep === 1" />
    </v-fade-transition>
    <v-fade-transition>
      <RaceCultureStep v-if="currentStep === 2" />
    </v-fade-transition>
    <v-fade-transition>
      <SkillsSelector v-if="currentStep === 3" />
    </v-fade-transition>
    <v-fade-transition>
      <EquipmentSelector v-if="currentStep === 4" />
    </v-fade-transition>
    <v-fade-transition>
      <FinalTouches v-if="currentStep === 6" />
    </v-fade-transition>
  </div>
</template>
