<script setup lang="ts">
defineProps<{ loading: boolean, enabled: boolean, buttonLabel: string }>()
defineEmits<{(eventName: 'button-clicked'): void }>()
</script>

<template>
  <v-btn
    color="primary"
    :prepend-icon="loading ? 'mdi-loading' : ''"
    variant="elevated"
    :disabled="!enabled || loading"
    @click="$emit('button-clicked')"
  >
    {{ buttonLabel }}
  </v-btn>
</template>
