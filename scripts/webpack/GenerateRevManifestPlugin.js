const { generateRevManifest } = require('../generateRevManifest');

class GenerateManifestPlugin {
  constructor(options) {
    this.options = options;
  }

  apply(compiler) {
    // Hook into the afterEmit event to generate the rev manifest
    compiler.hooks.afterEmit.tapAsync('GenerateManifestPlugin', (compilation, callback) => {
      const revManifestEntry = compiler.options.output.path;

      // Generate the rev manifest based on webpack's output path
      generateRevManifest(revManifestEntry, this.options.manifestPath);
      callback();
    });
  }
}

module.exports = GenerateManifestPlugin;
