<script setup lang="ts">
import { ref } from 'vue'
import LoginForm from '@/UI/components/Account/LoginForm.vue'
import router from '@/UI/router/index'

const showLoginError = ref(false)
const loading = ref(false)

const onLoginButtonClicked = async (email: string, password: string):Promise<void> => {
  console.log(email, password);
  loading.value = true
  const response = await fetch('/api/login', {
    method: 'POST',
    body: JSON.stringify({ email: email, pass: password })
  })
  if (response.status === 403) {
    showLoginError.value = true;
    loading.value = false
    return
  }
  // const parsedResponse = await response.json();
  router.push({ name: 'Dashboard' })
}
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
