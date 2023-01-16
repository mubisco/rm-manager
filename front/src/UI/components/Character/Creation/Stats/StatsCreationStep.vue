<script setup lang="ts">
import { ref } from 'vue'

const selectedMethod = ref('POINTS_FIXED')
</script>
<template>
  <div>
    <v-radio-group
      v-model="selectedMethod"
      inline
    >
      <v-radio
        :label="$t('character.stats-step.method.roll')"
        color="primary"
        value="ROLL"
      />
      <v-radio
        :label="$t('character.stats-step.method.points-fixed')"
        color="primary"
        value="POINTS_FIXED"
      />
      <v-radio
        :label="$t('character.stats-step.method.points-rolled')"
        color="primary"
        value="POINTS_WITH_ROLL"
      />
    </v-radio-group>
  </div>
</template>
