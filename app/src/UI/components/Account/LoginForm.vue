<script setup lang="ts">
import { ref, computed, defineEmits, defineProps } from 'vue'

defineProps<{ loading: boolean }>()
defineEmits<{ (eventName: 'login-button-clicked', email: string, password: string): Promise<void> }>()
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
          {{ $t('login.title') }}
        </v-card-title>
      </v-card-header-text>
    </v-card-header>
    <v-card-text>
      <v-form
        v-cy:login-form
      >
        <div>
          <v-text-field
            v-model="email"
            v-cy:login-email
            :label="$t('login.email')"
            variant="outlined"
            color="primary"
            required
            :error="emailError"
            :disabled="loading"
          />
        </div>
        <div>
          <v-text-field
            v-model="password"
            v-cy:login-password
            :label="$t('login.password')"
            variant="outlined"
            color="primary"
            type="password"
            required
            :disabled="loading"
          />
        </div>
        <p class="text-right">
          <router-link
            v-cy:login-forgot
            :to="{name: 'ForgotPassword'}"
          >
            {{ $t('login.forgot-password') }}
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
        :disabled="!canLogin || loading"
        @click="$emit('login-button-clicked', email, password)"
      >
        {{ $t('login.action') }}
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
