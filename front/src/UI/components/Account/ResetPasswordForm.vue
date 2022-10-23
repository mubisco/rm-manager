<script setup lang="ts">
import { ref, computed } from 'vue'
import router from '@/UI/router/index'
import { useI18n } from 'vue-i18n'
import { ResetPasswordCommandHandler } from '@/Application/Command/User/ResetPasswordCommandHandler'
import { ResetPasswordCommand } from '@/Application/Command/User/ResetPasswordCommand'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { UserNotFoundError } from '@/Domain/User/UserNotFoundError'
import LoadingButton from '@/UI/components/Shared/LoadingButton.vue'
import { useSnackbarStore } from '@/UI/stores/snackbar'

const snackbarStore = useSnackbarStore()
const { t } = useI18n()
const username = ref('')
const loading = ref(false)
const buttonEnabled = computed(() => username.value !== '' && username.value.length > 3)

const onRecoverButtonClicked = async () => {
  loading.value = true
  const handler = new ResetPasswordCommandHandler(new AxiosUserClient())
  const command = new ResetPasswordCommand(username.value)
  try {
    await handler.handle(command)
    snackbarStore.addMessage(t('forgotPassword.resetOk'), 'success')
    router.push({ name: 'Login' })
  } catch (err: unknown) {
    if (err instanceof UserNotFoundError) {
      const message = t('forgotPassword.notExists', { username: username.value })
      snackbarStore.addMessage(message, 'error')
      return
    }
    snackbarStore.addMessage(t('forgotPassword.serverError'), 'error')
  } finally {
    loading.value = false
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
  </div>
</template>
