const path = require('path')
const { startDevServer } = require("@cypress/vite-dev-server");

module.exports = (on, config) => {
  on("dev-server:start", (options) => {
    const configFile = path.resolve(__dirname, "..", "..", "..", "vite.config.ts")
    console.log('configFile', configFile);
    return startDevServer({
      options,
      viteConfig: {
        configFile: configFile
      },
    });
  });
};
