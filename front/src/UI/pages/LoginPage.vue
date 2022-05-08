<script setup lang="ts">
import { ref, onMounted } from 'vue'
import LoginForm from '@/UI/components/Account/LoginForm.vue'
import router from '@/UI/router/index'
import { useUserStore } from '@/UI/stores/user'

const showLoginError = ref(false)
const loading = ref(false)
const userStore = useUserStore();

const onLoginButtonClicked = async (email: string, password: string):Promise<void> => {
  loading.value = true
  const loginResult = await userStore.login(email, password);
  showLoginError.value = !loginResult
  loading.value = false
  if (loginResult === true) {
    router.push({ name: 'Dashboard' })
  }
}

onMounted(async () => {
  const userIsLogged = await userStore.refresh()
  if (userIsLogged) {
    router.push({ name: 'Dashboard' })
  }
})
</script>

<template>
  <div class="mt-8 d-flex justify-center">
    <login-form
      :loading="loading"
      @login-button-clicked="onLoginButtonClicked"
    />
  </div>
  <v-snackbar
    v-model="showLoginError"
    v-cy:login-error
    timeout="3000"
    color="error"
  >
    {{ $t('login.error') }}
  </v-snackbar>
</template>
