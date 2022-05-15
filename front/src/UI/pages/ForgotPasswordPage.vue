<script setup lang="ts">
import { onMounted } from 'vue'
import ResetPasswordForm from '@/UI/components/Account/ResetPasswordForm.vue'
import { useUserStore } from '@/UI/stores/user'
import router from '@/UI/router/index'

const userStore = useUserStore();

onMounted(() => {
  if (userStore.isLogged) {
    router.replace({ name: 'Dashboard' })
  }
})
</script>

<template>
  <div class="mt-8 d-flex justify-center">
    <reset-password-form />
  </div>
</template>
