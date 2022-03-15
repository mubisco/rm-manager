<script setup lang="ts">
import { defineEmits, defineProps } from 'vue'

defineProps<{ drawerOpened: boolean }>()

defineEmits<{ (eventName: 'drawer:toggle'): void }>()
</script>
<template>
  <v-app-bar
    app
    color="primary"
  >
    <template #prepend>
      <v-app-bar-nav-icon
        color="primary"
        @click="() => $emit('drawer:toggle')"
      />

      <v-app-bar-title>SIR</v-app-bar-title>
    </template>
    <template #append>
      <v-btn
        icon="mdi-account"
        color="primary"
        :to="{ name: 'Login' }"
      />
    </template>
  </v-app-bar>
</template>
