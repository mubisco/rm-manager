<script setup lang="ts">
import { ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import NavigationBar from './NavigationBar.vue'
import DrawerContent from './DrawerContent.vue'
import DiceBag from '@/UI/components/DiceBag/DiceBag.vue'
import { useSnackbarStore } from '@/UI/stores/snackbar'
import { useDicebagStore } from '@/UI/stores/dicebag'

const rightDrawerOpened = ref(false)
const drawerOpened = ref(false)
const showSnackbar = ref(false)
const snackbarType = ref('success')
const snackbarMessage = ref('')
const snackbarStore = useSnackbarStore()
const dicebagStore = useDicebagStore()
const { messageCount } = storeToRefs(snackbarStore)
const { dicebagDefinition } = storeToRefs(dicebagStore)

watch(messageCount, () => {
  const message = snackbarStore.consume()
  if (message !== undefined) {
    snackbarType.value = message.messageType
    snackbarMessage.value = message.messageContent
    showSnackbar.value = true
  }
})
watch(dicebagDefinition, () => {
  rightDrawerOpened.value = dicebagStore.dicebagDefinition !== ''
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
    <v-navigation-drawer
      v-model="rightDrawerOpened"
      location="right"
      temporary
    >
      <DiceBag
        :dice-bag-definition="dicebagStore.dicebagDefinition"
        @dicebag:rolled="dicebagStore.doRoll"
      />
    </v-navigation-drawer>
    <navigation-bar
      :drawer-opened="drawerOpened"
      @drawer:toggle="drawerOpened = !drawerOpened"
      @dicebag:toggle="rightDrawerOpened = !rightDrawerOpened"
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
