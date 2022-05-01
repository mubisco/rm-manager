/// <reference types="vitest" />
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vuetify from '@vuetify/vite-plugin'
import path from 'path'
import vueI18n from '@intlify/vite-plugin-vue-i18n'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vuetify({
      autoImport: true,
    }),
    vueI18n({
      globalSFCScope: true,
      include: path.resolve(__dirname, './src/UI/plugins/locales/**')
    })
  ],
  define: { 'process.env': {} },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
    },
  },
  test: {
    environment: 'jsdom',
    include: ['tests/**/*.test.ts'],
    setupFiles: 'tests/test-setup.js',
    clearMocks: true,
    deps: {
      inline: ['@vue', '@vueuse', 'vue-demi', 'vuetify'],
    }
  }
})
