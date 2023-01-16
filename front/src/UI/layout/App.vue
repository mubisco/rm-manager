<script setup lang="ts">
import { ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import NavigationBar from './NavigationBar.vue'
import DrawerContent from './DrawerContent.vue'
import { useSnackbarStore } from '@/UI/stores/snackbar'

const drawerOpened = ref(false)
const showSnackbar = ref(false)
const snackbarType = ref('success')
const snackbarMessage = ref('')
const snackbarStore = useSnackbarStore()
const { messageCount } = storeToRefs(snackbarStore)

watch(messageCount, () => {
  const message = snackbarStore.consume()
  if (message !== undefined) {
    snackbarType.value = message.messageType
    snackbarMessage.value = message.messageContent
    showSnackbar.value = true
  }
})

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
      <v-snackbar
        v-model="showSnackbar"
        timeout="3000"
        :color="snackbarType"
      >
        <span
          v-cy:snackbar-message
        >
          {{ snackbarMessage }}
        </span>
      </v-snackbar>
    </v-main>

    <v-footer app />
  </v-app>
</template>

<style>
p { margin-bottom: 1rem; }
</style>
