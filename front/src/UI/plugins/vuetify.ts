// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { aliases, mdi } from 'vuetify/iconsets/mdi'

// Vuetify
import { createVuetify } from 'vuetify'
import { md3 } from 'vuetify/blueprints'

export default createVuetify({
  blueprint: md3,
  /*
  theme: {
    defaultTheme: 'dark'
  }
  */
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi
    }
  }
})
