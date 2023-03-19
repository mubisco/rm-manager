<script setup lang="ts">
import { ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import NavigationBar from './NavigationBar.vue'
import GlobalSnackbar from './GlobalSnackbar.vue'
import DrawerContent from './DrawerContent.vue'
import DiceBag from '@/UI/components/DiceBag/DiceBag.vue'
import { useDicebagStore } from '@/UI/stores/dicebag'

const rightDrawerOpened = ref(false)
const drawerOpened = ref(false)
const dicebagStore = useDicebagStore()
const { dicebagDefinition } = storeToRefs(dicebagStore)

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
        @dicebag:rolled="dicebagStore.updateResult"
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
      <GlobalSnackbar />
    </v-main>
    <v-footer app />
  </v-app>
</template>

<style>
p { margin-bottom: 1rem; }
</style>
