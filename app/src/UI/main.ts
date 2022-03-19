import { createApp } from 'vue'
import vuetify from '@/UI/plugins/vuetify'
import { loadFonts } from '@/UI/plugins/webfontloader'
import { i18n } from '@/UI/plugins/i18n'
import router from '@/UI/router/index'
import App from '@/UI/layout/App.vue'

loadFonts()


const app = createApp(App)
app.directive('cy', {
  // en función de la variable NODE_ENV escupo o no el valor
  beforeMount: (el, binding) => {
    el.dataset.cy = binding.arg
  },
  updated: (el, binding) => {
    el.dataset.cy = binding.arg
  }
})
app.use(vuetify)
app.use(i18n)
app.use(router)
app.mount('#app')
