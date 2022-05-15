<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useUserStore } from '@/UI/stores/user'
import router from '@/UI/router/index'
import { useI18n } from 'vue-i18n'
import { ResetPasswordCommandHandler } from '@/Application/Command/User/ResetPasswordCommandHandler'
import { ResetPasswordCommand } from '@/Application/Command/User/ResetPasswordCommand'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
const { t } = useI18n()


const userStore = useUserStore();
const username = ref('')
const snackbarBackground = ref('error')
const showSnackbar = ref(false)
const snackbarError = ref('')
const buttonEnabled = computed(() => username.value !== '' && username.value.length > 3)

onMounted(() => {
  if (userStore.isLogged) {
    router.replace({ name: 'Dashboard' })
  }
})

const onRecoverButtonClicked = async () => {
  const handler = new ResetPasswordCommandHandler(new AxiosUserClient())
  const command = new ResetPasswordCommand(username.value)
  try {
    await handler.handle(command)
    snackbarError.value = t('forgotPassword.resetOk')
    snackbarBackground.value = 'success'
  } catch (err: unknown) {
    if (err instanceof UserNotFoundError) {
      snackbarError.value = t('forgotPassword.notExists', { username: username })
      snackbarBackground.value = 'error'
      return
    }
    snackbarError.value = t('forgotPassword.serverError')
    snackbarBackground.value = 'error'
  } finally {
    showSnackbar.value = true
  }
}
</script>

<template>
  <div class="mt-8 d-flex justify-center">
    <v-card width="550">
      <v-card-header>
        <v-card-header-text>
          <v-card-title class="text-primary">
            {{ $t('forgotPassword.title') }}
          </v-card-title>
        </v-card-header-text>
      </v-card-header>
      <v-card-text>
        <v-form
          v-cy:recover-password-form
        >
          <v-text-field
            v-model="username"
            v-cy:recover-password-input
            :label="$t('forgotPassword.username')"
            variant="outlined"
            color="primary"
            required
          />
        </v-form>
      </v-card-text>
      <v-card-actions class="d-flex justify-end">
        <v-btn
          v-cy:recover-password-button
          color="primary"
          variant="contained"
          :disabled="!buttonEnabled"
          @click="onRecoverButtonClicked"
        >
          {{ $t('forgotPassword.action') }}
        </v-btn>
      </v-card-actions>
    </v-card>
    <v-snackbar
      v-model="showSnackbar"
      v-cy:recover-password-snackbar
      timeout="3000"
      :color="snackbarBackground"
    >
      {{ snackbarError }}
    </v-snackbar>
  </div>
</template>
