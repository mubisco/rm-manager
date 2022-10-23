<script setup lang="ts">
import { ref, onMounted } from 'vue'
import router from '@/UI/router/index'
import { useRoute } from 'vue-router'
import { AxiosPasswordTokenClient } from '@/Infrastructure/User/Client/AxiosPasswordTokenClient'
import { CheckResetPasswordTokenQuery } from '@/Application/User/Query/CheckResetPasswordTokenQuery'
import { CheckResetPasswordTokenQueryHandler } from '@/Application/User/Query/CheckResetPasswordTokenQueryHandler'
import ChangePasswordForm from '@/UI/components/Account/ChangePasswordForm.vue'
import { ChangePasswordCommandHandler } from '@/Application/User/Command/ChangePasswordCommandHandler'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { ChangePasswordCommand } from '@/Application/User/Command/ChangePasswordCommand'
import { useSnackbarStore } from '@/UI/stores/snackbar'
import { useI18n } from 'vue-i18n'

const snackbarStore = useSnackbarStore()
const { t } = useI18n()
const route = useRoute()
const loading = ref(true)
const sendingPassword = ref(false)

onMounted(async () => {
  const query = new CheckResetPasswordTokenQuery(route.params.token as string)
  const queryHandler = new CheckResetPasswordTokenQueryHandler(new AxiosPasswordTokenClient())
  const response = await queryHandler.handle(query)
  if (response === 'NOT_FOUND') {
    snackbarStore.addMessage(t('token.error'), 'error')
  }
  if (response === 'OK') {
    loading.value = false
  }
})

const onSendPasswordButtonClicked = async (newPassword: string):Promise<void> => {
  sendingPassword.value = true
  const commandHandler = new ChangePasswordCommandHandler(new AxiosUserClient())
  const command = new ChangePasswordCommand(route.params.token as string, newPassword)
  try {
    await commandHandler.handle(command)
    sendingPassword.value = false
    snackbarStore.addMessage(t('changePassword.success'), 'success')
    router.push({ name: 'Login' })
  } catch {
    loading.value = false
    snackbarStore.addMessage(t('changePassword.error'), 'error')
  }
}

</script>

<template>
  <div
    class="d-flex justify-center mb-6 mt-6"
  >
    <v-progress-circular
      v-if="loading"
      v-cy:reset-password-loader
      indeterminate
      color="primary"
    />
    <change-password-form
      v-if="!loading"
      :loading="sendingPassword"
      @send-password-clicked="onSendPasswordButtonClicked"
    />
  </div>
</template>
