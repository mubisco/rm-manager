import { useUserStore } from '@/UI/stores/user'
import { storeToRefs } from 'pinia'
import router from '@/UI/router/index'

export function useLogout () {
  const userStore = useUserStore()
  const { isLogged } = storeToRefs(userStore)

  const onLogoutButtonClicked = async () => {
    await userStore.logout()
    router.push({ name: 'Login' })
  }
  return { isLogged, onLogoutButtonClicked }
}
