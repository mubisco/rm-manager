import { createApp } from 'vue'
import router from '@/UI/router/index'
import App from '@/UI/App.vue'
import './index.css'

const app = createApp(App)
app.use(router)
app.mount('#app')
