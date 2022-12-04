<script setup lang="ts">
import WizardHeader from '@/UI/components/Character/Creation/WizardHeader.vue'
import { ref } from 'vue'

const currentStep = ref(0)

</script>
<template>
  <WizardHeader :current-step="currentStep" />
</template>
