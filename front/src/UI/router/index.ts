import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/UI/pages/Home.vue'
import LoginPage from '@/UI/pages/LoginPage.vue'
import ForgotPasswordPage from '@/UI/pages/ForgotPasswordPage.vue'
import DashboardPage from '@/UI/pages/DashboardPage.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage,
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: ForgotPasswordPage,
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: DashboardPage,
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

export default router
