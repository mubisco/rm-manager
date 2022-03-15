import { createApp } from 'vue'
import vuetify from '@/UI/plugins/vuetify'
import { loadFonts } from '@/UI/plugins/webfontloader'
import router from '@/UI/router/index'
import App from '@/UI/layout/App.vue'

loadFonts()

createApp(App)
  .use(vuetify)
  .use(router)
  .mount('#app')
