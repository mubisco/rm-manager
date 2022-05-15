<script setup lang="ts">
import { defineEmits, defineProps } from 'vue'

defineProps<{ loading: boolean, enabled: boolean, buttonLabel: string }>()
defineEmits<{ (eventName: 'button-clicked'): void }>()
</script>

<template>
  <v-btn
    color="primary"
    :prepend-icon="loading ? 'mdi-loading' : ''"
    variant="contained"
    :disabled="!enabled || loading"
    @click="$emit('button-clicked')"
  >
    {{ buttonLabel }}
  </v-btn>
</template>
