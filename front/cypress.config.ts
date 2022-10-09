import { defineConfig } from 'cypress'
import vitePreprocessor from 'cypress-vite'

export default defineConfig({
  e2e: {
    "baseUrl": "http://localhost:5000",
    "downloadsFolder": "tests/e2e/downloads",
    "fixturesFolder": "tests/e2e//fixtures",
    "specPattern": "tests/e2e/integration",
    setupNodeEvents(on) {
      on("file:preprocessor", vitePreprocessor())
    },
    "videosFolder": "tests/e2e/videos",
    "screenshotsFolder": "tests/e2e/screenshots",
    "supportFile": "tests/e2e/support/commands.ts"
  }
})
