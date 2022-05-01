<script setup lang="ts">
import { ref } from 'vue'
import NavigationBar from './NavigationBar.vue'
import DrawerContent from './DrawerContent.vue'

const drawerOpened = ref(false)

</script>
<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawerOpened"
      app
    >
      <drawer-content />
    </v-navigation-drawer>
    <navigation-bar
      :drawer-opened="drawerOpened"
      @drawer:toggle="drawerOpened = !drawerOpened"
    />
    <v-main>
      <v-container fluid>
        <router-view />
      </v-container>
    </v-main>

    <v-footer app />
  </v-app>
</template>
