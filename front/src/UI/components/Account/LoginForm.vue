<script setup lang="ts">
import { ref, computed } from 'vue'
import LoadingButton from '@/UI/components/Shared/LoadingButton.vue'

defineProps<{ loading: boolean }>()
defineEmits<{(eventName: 'login-button-clicked', username: string, password: string): Promise<void> }>()
const username = ref('')
const password = ref('')
const canLogin = computed(() => !emailError.value && password.value !== '')
const emailError = computed(():boolean => {
  const regexEmail = /^[0-9a-zA-Z_]*$/
  return username.value !== '' && !username.value.match(regexEmail)
})

</script>

<template>
  <v-card
    width="550"
    :title="$t('login.title')"
  >
    <v-card-text>
      <v-form
        v-cy:login-form
      >
        <div>
          <v-text-field
            v-model="username"
            v-cy:login-username
            :label="$t('login.username')"
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
      <loading-button
        v-cy:login-button
        :button-label="$t('login.action')"
        :enabled="canLogin"
        :loading="loading"
        @button-clicked="$emit('login-button-clicked', username, password)"
      />
    </v-card-actions>
  </v-card>
</template>
