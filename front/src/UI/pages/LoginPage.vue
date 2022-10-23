<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useI18n } from 'vue-i18n'
import LoginForm from '@/UI/components/Account/LoginForm.vue'
import router from '@/UI/router/index'
import { useUserStore } from '@/UI/stores/user'
import { useSnackbarStore } from '@/UI/stores/snackbar'

const { t } = useI18n()
const loading = ref(false)
const userStore = useUserStore()
const snackbarStore = useSnackbarStore()

const onLoginButtonClicked = async (email: string, password: string):Promise<void> => {
  loading.value = true
  const loginResult = await userStore.login(email, password)
  loading.value = false
  if (loginResult === true) {
    router.push({ name: 'Dashboard' })
  }
  if (!loginResult) {
    snackbarStore.addMessage(
      t('login.error'),
      'error'
    )
  }
}

onMounted(async () => {
  const userIsLogged = await userStore.refresh()
  if (userIsLogged) {
    router.push({ name: 'Dashboard' })
  }
})
</script>

<template>
  <div class="mt-8 d-flex justify-center">
    <login-form
      :loading="loading"
      @login-button-clicked="onLoginButtonClicked"
    />
  </div>
</template>
