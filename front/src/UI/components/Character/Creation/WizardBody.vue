<script setup lang="ts">
import { defineProps, ref } from 'vue'
import ProfessionSelector from '@/UI/components/Character/Creation/ProfessionSelector.vue'
import StatsDefine from '@/UI/components/Character/Creation/StatsDefine.vue'
import RaceSelector from '@/UI/components/Character/Creation/RaceSelector.vue'
import SkillsSelector from '@/UI/components/Character/Creation/SkillsSelector.vue'
import EquipmentSelector from '@/UI/components/Character/Creation/EquipmentSelector.vue'
import FinalTouches from '@/UI/components/Character/Creation/FinalTouches.vue'

defineProps<{ currentStep: number }>()
</script>
<template>
  <div>
    <v-fade-transition>
      <ProfessionSelector v-if="currentStep === 0" />
    </v-fade-transition>
    <v-fade-transition>
      <StatsDefine v-if="currentStep === 1" />
    </v-fade-transition>
    <v-fade-transition>
      <RaceSelector v-if="currentStep === 2" />
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
