<script setup lang="ts">
import { ref, onMounted } from 'vue'
import router from '@/UI/router/index'
import { useRoute } from 'vue-router'
import { AxiosPasswordTokenClient } from '@/Infrastructure/User/Client/AxiosPasswordTokenClient'
import { CheckResetPasswordTokenQuery } from '@/Application/User/Query/CheckResetPasswordTokenQuery'
import { CheckResetPasswordTokenQueryHandler } from '@/Application/User/Query/CheckResetPasswordTokenQueryHandler'
import ChangePasswordForm from '@/UI/components/Account/ChangePasswordForm.vue'
import { ChangePasswordCommandHandler } from '@/Application/Command/User/ChangePasswordCommandHandler'
import { AxiosUserClient } from '@/Infrastructure/User/Client/AxiosUserClient'
import { ChangePasswordCommand } from '@/Application/Command/User/ChangePasswordCommand'

const route = useRoute()
const showError = ref(false)
const showSuccess = ref(false)
const loading = ref(true)
const sendingPassword = ref(false)

onMounted(async () => {
  const query = new CheckResetPasswordTokenQuery(route.params.token as string)
  const queryHandler = new CheckResetPasswordTokenQueryHandler(new AxiosPasswordTokenClient())
  const response = await queryHandler.handle(query)
  if (response === 'NOT_FOUND') {
    showError.value = true
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
    showSuccess.value = true
    router.push({ name: 'Login' })
  } catch {
    loading.value = false
    showError.value = true
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
    <v-snackbar
      v-model="showError"
      timeout="3000"
      color="error"
    >
      <span
        v-cy:token-error
      >
        {{ $t('token.error') }}
      </span>
    </v-snackbar>
    <v-snackbar
      v-model="showSuccess"
      timeout="3000"
      color="success"
    >
      <span
        v-cy:token-success
      >
        {{ $t('token.success') }}
      </span>
    </v-snackbar>
  </div>
</template>
