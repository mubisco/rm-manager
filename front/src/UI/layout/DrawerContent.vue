<script setup lang="ts">
import { useLogout } from './useLogout'
const { isLogged, onLogoutButtonClicked } = useLogout()
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
      prepend-icon="mdi-home"
      title="Home"
      value="home"
      :to="{ name: 'ForgotPassword' }"
    />
    <v-list-item
      v-if="!isLogged"
      v-cy:login-left-button
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
      @click="onLogoutButtonClicked"
    />
  </v-list>
</template>
