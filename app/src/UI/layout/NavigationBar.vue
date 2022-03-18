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
        @click="() => $emit('drawer:toggle')"
      />
    </template>
    <v-app-bar-title>SIR</v-app-bar-title>
    <template #append>
      <v-btn
        icon="mdi-account"
        :to="{ name: 'Login' }"
      />
    </template>
  </v-app-bar>
</template>
