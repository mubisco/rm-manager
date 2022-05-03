import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/UI/pages/Home.vue'
import LoginPage from '@/UI/pages/LoginPage.vue'
import ForgotPasswordPage from '@/UI/pages/ForgotPasswordPage.vue'
import DashboardPage from '@/UI/pages/DashboardPage.vue'
import pinia from '@/UI/stores/store'
import { useUserStore } from '@/UI/stores/user'

const userStore = useUserStore(pinia)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: { requiresAuth: true }
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage,
    meta: { requiresAuth: false }
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: ForgotPasswordPage,
    meta: { requiresAuth: false }
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: DashboardPage,
    meta: { requiresAuth: true }
  },
  /*{
    path: '/:catchAll(.*)*',
    name: "PageNotFound",
    component: PageNotFound,
  },*/
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to) => {
  if (to.meta.requiresAuth && !userStore.isLogged) {
    return { path: '/login' }
  }
})

export default router
