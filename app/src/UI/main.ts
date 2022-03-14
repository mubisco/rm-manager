import { createApp } from 'vue'
import router from '@/UI/router/index'
import App from '@/UI/App.vue'
import './index.css'

createApp(App).use(router).mount('#app')
