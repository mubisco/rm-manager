<script setup lang="ts">
import { defineEmits, defineProps } from 'vue'
import { useUserStore } from '@/UI/stores/user'
import { storeToRefs } from 'pinia'

defineProps<{ drawerOpened: boolean }>()
defineEmits<{ (eventName: 'drawer:toggle'): void }>()

const { isLogged } = storeToRefs(useUserStore())
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
    <v-app-bar-title tag="div">
      SIR
    </v-app-bar-title>
    <template #append>
      <v-btn
        v-if="!isLogged"
        icon="mdi-account"
        :to="{ name: 'Login' }"
      />
      <v-btn
        v-if="isLogged"
        v-cy:logout-top-button
        icon="mdi-logout-variant"
      />
    </template>
  </v-app-bar>
</template>
