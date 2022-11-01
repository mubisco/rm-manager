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
    theme="dark"
  >
    <template #prepend>
      <v-app-bar-nav-icon
        v-cy:left-drawer-button
        icon="mdi-menu"
        color="white"
        @click="() => $emit('drawer:toggle')"
      />
    </template>
    <v-app-bar-title tag="div">
      {{ $t('nav.title') }}
    </v-app-bar-title>
    <template #append>
      <v-btn
        v-if="!isLogged"
        v-cy:login-top-button
        color="white"
        icon="mdi-account"
      />
      <v-btn
        v-if="isLogged"
        v-cy:logout-top-button
        icon="mdi-logout-variant"
        color="white"
        @click="onLogoutButtonClicked"
      />
    </template>
  </v-app-bar>
</template>
