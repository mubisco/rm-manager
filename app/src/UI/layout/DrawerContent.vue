<script setup lang="ts">
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
      prepend-icon="mdi-account"
      title="Login"
      value="login"
      :to="{ name: 'Login' }"
    />
  </v-list>
</template>
