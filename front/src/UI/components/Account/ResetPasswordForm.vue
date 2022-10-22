<script setup lang="ts">
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { ResetPasswordCommandHandler } from '@/Application/Command/User/ResetPasswordCommandHandler'
import { ResetPasswordCommand } from '@/Application/Command/User/ResetPasswordCommand'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
import LoadingButton from '@/UI/components/Shared/LoadingButton.vue'
const { t } = useI18n()

const username = ref('')
const snackbarBackground = ref('error')
const showSnackbar = ref(false)
const loading = ref(false)
const snackbarError = ref('')
const buttonEnabled = computed(() => username.value !== '' && username.value.length > 3)

const onRecoverButtonClicked = async () => {
  loading.value = true
  const handler = new ResetPasswordCommandHandler(new AxiosUserClient())
  const command = new ResetPasswordCommand(username.value)
  try {
    await handler.handle(command)
    snackbarError.value = t('forgotPassword.resetOk')
    snackbarBackground.value = 'success'
  } catch (err: unknown) {
    if (err instanceof UserNotFoundError) {
      snackbarError.value = t('forgotPassword.notExists', { username: username.value })
      snackbarBackground.value = 'error'
      return
    }
    snackbarError.value = t('forgotPassword.serverError')
    snackbarBackground.value = 'error'
  } finally {
    loading.value = false
    showSnackbar.value = true
  }
}
</script>

<template>
  <div>
    <v-card
      width="550"
      :title="$t('forgotPassword.title')"
    >
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
            :disabled="loading"
            required
          />
        </v-form>
      </v-card-text>
      <v-card-actions class="d-flex justify-end">
        <loading-button
          v-cy:recover-password-button
          :button-label="$t('forgotPassword.action')"
          :enabled="buttonEnabled"
          :loading="loading"
          @button-clicked="onRecoverButtonClicked"
        />
      </v-card-actions>
    </v-card>
    <v-snackbar
      v-model="showSnackbar"
      timeout="30000"
      :color="snackbarBackground"
    >
      <span v-cy:recover-password-snackbar>
        {{ snackbarError }}
      </span>
    </v-snackbar>
  </div>
</template>
