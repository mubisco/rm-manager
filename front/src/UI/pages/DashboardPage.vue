<script setup lang="ts">
import { useUserStore } from '@/UI/stores/user'
import { storeToRefs } from 'pinia'
import PlayerDashboard from '@/UI/components/Dashboard/PlayerDashboard.vue'

const userStore = useUserStore()
const { userRole } = storeToRefs(userStore)

</script>

<template>
  <div class="mt-8 d-flex justify-center">
    <h1
      v-if="userRole !== 'USER'"
      v-cy:under-construction
    >
      <v-icon color="primary">
        mdi-wrench
      </v-icon>
      Dashboard page --- UNDER CONSTRUCTION ---
    </h1>
    <PlayerDashboard v-if="userRole === 'USER'" />
  </div>
</template>
