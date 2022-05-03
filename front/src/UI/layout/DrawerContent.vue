<script setup lang="ts">
import { useUserStore } from '@/UI/stores/user'
import { storeToRefs } from 'pinia'

const { isLogged } = storeToRefs(useUserStore())
</script>
<template>
  <v-list
    density="compact"
    nav
  >
    <v-list-item
      prepend-icon="mdi-home"
      title="Home"
      value="home"
      :to="{ name: 'Home' }"
    />
    <v-list-item
      v-if="!isLogged"
      prepend-icon="mdi-account"
      title="Login"
      value="login"
      :to="{ name: 'Login' }"
    />
    <v-list-item
      v-if="isLogged"
      v-cy:logout-left-button
      prepend-icon="mdi-logout-variant"
      title="Logout"
      value="logout"
      :to="{ name: 'Login' }"
    />
  </v-list>
</template>
