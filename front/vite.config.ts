/// <reference types="vitest" />
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vuetify from 'vite-plugin-vuetify'
import path from 'path'
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vuetify({ autoImport: true }),
    VueI18nPlugin({
      globalSFCScope: true,
      include: path.resolve(__dirname, './src/UI/plugins/locales/**')
    })
  ],
  server: {
    host: true,
    port: 5000
  },
  define: { 'process.env': {} },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src')
    }
  },
  test: {
    environment: 'jsdom',
    include: ['tests/**/*.test.ts'],
    setupFiles: 'tests/test-setup.js',
    clearMocks: true,
    deps: {
      inline: ['@vue', '@vueuse', 'vue-demi', 'vuetify']
    }
  }
})
