<script setup lang="ts">
import WizardHeader from '@/UI/components/Character/Creation/WizardHeader.vue'
import WizardBody from '@/UI/components/Character/Creation/WizardBody.vue'
import { ref } from 'vue'

const currentStep = ref(2)

</script>
<template>
  <v-card>
    <WizardHeader
      :current-step="currentStep"
    />
    <v-card-text>
      <WizardBody
        :current-step="currentStep"
      />
    </v-card-text>
    <v-card-actions class="justify-space-between">
      <v-btn
        @click="currentStep--"
      >
        Anterior
      </v-btn>
      <v-btn @click="currentStep++">
        Siguiente
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
