<script setup lang="ts">
import { defineEmits, defineProps } from 'vue'
import { useLogout } from './useLogout'

defineProps<{ drawerOpened: boolean }>()
defineEmits<{(eventName: 'drawer:toggle'): void }>()

const { isLogged, onLogoutButtonClicked } = useLogout()
</script>
<template>
  <v-app-bar
    app
    color="primary"
  >
    <template #prepend>
      <v-app-bar-nav-icon
        v-cy:left-drawer-button
        @click="() => $emit('drawer:toggle')"
      />
    </template>
    <v-app-bar-title tag="div">
      SIR
    </v-app-bar-title>
    <template #append>
      <v-btn
        v-if="!isLogged"
        v-cy:login-top-button
        icon="mdi-account"
        :to="{ name: 'Login' }"
      />
      <v-btn
        v-if="isLogged"
        v-cy:logout-top-button
        icon="mdi-logout-variant"
        @click="onLogoutButtonClicked"
      />
    </template>
  </v-app-bar>
</template>
