<script setup lang="ts">
import { ref, computed } from 'vue'
const valid = ref(false)
const email = ref('')
const password = ref('')
const canLogin = computed(() => !emailError.value && password.value !== '')
const emailError = computed(():boolean => {
  const regexEmail = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/
  return email.value !== '' && !email.value.match(regexEmail);
})
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
        variant="contained-text"
        :disabled="!canLogin"
      >
        Login
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
