<script setup lang="ts">
import { ref, computed } from 'vue'
import router from '@/UI/router/index'

const loading = ref(false)
const valid = ref(false)
const email = ref('')
const password = ref('')
const showLoginError = ref(false)
const canLogin = computed(() => !emailError.value && password.value !== '')
const emailError = computed(():boolean => {
  const regexEmail = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/
  return email.value !== '' && !email.value.match(regexEmail);
})

const onLoginButtonClicked = async ():Promise<void> => {
  loading.value = true
  const response = await fetch('/api/login', {
    method: 'POST',
    body: JSON.stringify({ email: email.value, pass: password.value })
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
  <v-card width="550">
    <v-card-header>
      <v-card-header-text>
        <v-card-title class="text-primary">
          Login
        </v-card-title>
      </v-card-header-text>
    </v-card-header>
    <v-card-text>
      <v-form
        v-model="valid"
        v-cy:login-form
      >
        <div>
          <v-text-field
            v-model="email"
            v-cy:login-email
            label="E-mail"
            variant="outlined"
            color="primary"
            required
            :error="emailError"
          />
        </div>
        <div>
          <v-text-field
            v-model="password"
            v-cy:login-password
            label="Password"
            variant="outlined"
            color="primary"
            type="password"
            required
          />
        </div>
        <p class="text-right">
          <router-link
            v-cy:login-forgot
            :to="{name: 'ForgotPassword'}"
          >
            Forgot your password?
          </router-link>
        </p>
      </v-form>
    </v-card-text>
    <v-card-actions class="d-flex justify-end">
      <v-btn
        v-cy:login-button
        color="primary"
        :prepend-icon="loading ? 'mdi-loading' : ''"
        variant="contained"
        :disabled="!canLogin"
        @click="onLoginButtonClicked"
      >
        Login
      </v-btn>
    </v-card-actions>
  </v-card>
  <v-snackbar
    v-model="showLoginError"
    v-cy:login-error
    timeout="3000"
    color="error"
  >
    Login not allowed. User/Pass wrong.
  </v-snackbar>
</template>
