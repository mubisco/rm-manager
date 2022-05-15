<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useUserStore } from '@/UI/stores/user'
import router from '@/UI/router/index'
import { useI18n } from 'vue-i18n'
const { t } = useI18n()


const userStore = useUserStore();
const username = ref('')
const snackbarBackground = ref('error')
const showError = ref(false)
const errorMessage = ref('')
const buttonEnabled = computed(() => username.value !== '' && username.value.length > 3)

onMounted(() => {
  if (userStore.isLogged) {
    router.replace({ name: 'Dashboard' })
  }
})

const onRecoverButtonClicked = async () => {
  console.log('onRecoverButtonClicked', username.value)
  if (username.value === 'someUsername') {
    errorMessage.value = t('forgotPassword.serverError')
    snackbarBackground.value = 'error'
  }
  if (username.value === 'notExistantUser') {
    errorMessage.value = t('forgotPassword.notExists', { username: username })
    snackbarBackground.value = 'error'
  }
  if (username.value === 'existantUser') {
    errorMessage.value = t('forgotPassword.resetOk')
    snackbarBackground.value = 'success'
  }
  console.log('onRecoverButtonClicked', errorMessage.value)
  showError.value = true
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
      v-model="showError"
      v-cy:recover-password-snackbar
      timeout="3000"
      :color="snackbarBackground"
    >
      {{ errorMessage }}
    </v-snackbar>
  </div>
</template>
