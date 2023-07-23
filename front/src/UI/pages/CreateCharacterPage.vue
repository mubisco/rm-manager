<script setup lang="ts">
import WizardHeader from '@/UI/components/Character/Creation/WizardHeader.vue'
import WizardBody from '@/UI/components/Character/Creation/WizardBody.vue'
import { ref } from 'vue'

const currentStep = ref(0)

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
    <v-card-actions
      :class="currentStep == 0 ? 'justify-end' : 'justify-space-between'"
    >
      <v-btn
        v-show="currentStep > 0"
        @click="currentStep--"
      >
        {{ $t('character.creation.previous') }}
      </v-btn>
      <v-btn
        v-if="currentStep < 6"
        @click="currentStep++"
      >
        {{ $t('character.creation.next') }}
      </v-btn>
      <v-btn
        v-else
      >
        {{ $t('character.creation.finish') }}
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
