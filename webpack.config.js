require('dotenv').config();

const fs = require('fs').promises; // Use promises for async operations (not the default)
const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const generateRevManifestPlugin = require('./scripts/webpack/GenerateRevManifestPlugin');

class TimestampPlugin {
  apply(compiler) {
    compiler.hooks.done.tap('TimestampPlugin', () => {
      const timestamp = new Date().toLocaleString();
      setImmediate(() => {
        const emoji = "✅"
        console.log(`${emoji} build completed ${timestamp}`);
      });
    });
  }
}

const outputDir = path.resolve(__dirname, 'public', 'dist');

// Async delete any directories passed in and wait for all deletions to complete
async function cleanDirectories(dirs) {
  const deletePromises = dirs.map(async (dir) => {
    const dirPath = path.resolve(outputDir, dir);
    try {
      const stat = await fs.stat(dirPath);
      if (stat.isDirectory()) {
        await fs.rm(dirPath, { recursive: true, force: true });
        console.log(`Deleted directory: ${dirPath}`);
      }
    } catch (err) {
      // n.b. ENOENT is expected if the directory doesn't exist
      if (err.code !== 'ENOENT') {
        console.error(`Failed to delete ${dirPath}:`, err);
      }
    }
  });

  await Promise.all(deletePromises);
}

// Use async function to trigger webpack to wait for the promise to resolve
module.exports = async () => {
  // Clean scripts and styles directories before the build process starts
  await cleanDirectories(['scripts', 'styles', 'images']);

  // Define if the environment is production
  const isProd = process.env.NODE_ENV === 'production';
  const isCI = process.env.CI === '1'; // Set in GitHub Action
  // Use content hash and generate manifest in production or when explicitly set
  const useContentHash = process.env.USE_COMPILED_REVASSETS === 'true' || isProd;

  // Resolve implicit promise with the Webpack configuration object
  return {
    mode: isProd ? 'production' : 'development',
    entry: {
      app: ['./frontend/scss/app.scss', './frontend/js/app.js'],
      blocks3D: ['./frontend/js/blocks3D.js'],
      blocks360: ['./frontend/js/blocks360.js'],
      collectionSearch: ['./frontend/js/collectionSearch.js'],
      head: ['./frontend/js/head.js'],
      interactiveFeatures: ['./frontend/js/interactiveFeatures.js'],
      layeredImageViewer: ['./frontend/js/layeredImageViewer.js'],
      mirador: ['./frontend/js/mirador.js'],
      myMuseumTourBuilder: ['./frontend/js/myMuseumTourBuilder.js'],
      recaptcha: ['./frontend/js/recaptcha.js'],
      videojs: ['./frontend/js/videojs.js'],
      virtualTour: ['./frontend/js/virtualTour.js'],
      html4css: ['./frontend/scss/html4css.scss'],
      'mirador-kiosk': ['./frontend/scss/mirador-kiosk.scss'],
      'my-museum-tour-pdf': ['./frontend/scss/my-museum-tour-pdf.scss'],
      print: ['./frontend/scss/print.scss'],
      setup: ['./frontend/scss/setup.scss'],
    },
    output: {
      filename: `./scripts/[name]${useContentHash ? '-[contenthash]' : ''}.js`,
      path: outputDir,
      publicPath: '/dist/',
    },
    devtool: 'source-map',
    optimization: {
      minimize: isProd && !isCI,
    },
    resolve: {
      extensions: ['.js', '.jsx', '.scss'],
      fallback: {
        url: false,
      },
    },
    plugins: [
      // Ignore unused libraries if CI is detected
      new webpack.IgnorePlugin({
        resourceRegExp: /@blueprintjs\/(core|icons)/,
      }),
      ...(isCI
        ? [
            new webpack.IgnorePlugin({
              resourceRegExp: /closer-look/,
            }),
          ]
        : []),
      new MiniCssExtractPlugin({
        filename: `styles/[name]${useContentHash ? '-[contenthash]' : ''}.css`,
      }),
      new CopyPlugin({
        patterns: [
          {
            from: 'frontend/images/**/*',
            to: `images/[name]${useContentHash ? '-[contenthash]' : ''}[ext]`,
          },
        ],
      }),
      // Only generate manifest if contentHashes are used
      ...(useContentHash
        ? [
          new generateRevManifestPlugin({
            manifestPath: path.resolve(outputDir, 'rev-manifest.json'),
          }),
        ] : []
      ),
      new TimestampPlugin(),
    ],
    module: {
      rules: [
        // Transpile JavaScript files using Babel
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          use: ['babel-loader'],
        },
        {
          test: /\.scss$/,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader',
              options: {
                url: false,
                sourceMap: true,
              },
            },
            {
              loader: 'sass-loader',
              options: {
                sourceMap: true,
              },
            },
          ],
        },
      ],
    },
  };
};
