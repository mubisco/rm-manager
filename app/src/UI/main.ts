import { createApp } from 'vue'
import router from '@/UI/router/index'
import App from '@/UI/App.vue'

const app = createApp(App)
app.use(router)
app.mount('#app')
