<template>
  <v-app>
    <v-navigation-drawer app>
      <!-- -->
    </v-navigation-drawer>

    <v-app-bar
      app
      color="primary"
    >
      <template #prepend>
        <v-app-bar-nav-icon color="primary" />
      </template>

      <v-app-bar-title>Photos</v-app-bar-title>

      <template #append>
        <v-btn
          icon="mdi-account"
          color="primary"
          to="/login"
        />
      </template>
    </v-app-bar>

    <v-main>
      <v-container fluid>
        <router-view />
      </v-container>
    </v-main>

    <v-footer app>
      <!-- -->
    </v-footer>
  </v-app>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'App',

  data () {
    return {
      //
    }
  },
})
</script>
