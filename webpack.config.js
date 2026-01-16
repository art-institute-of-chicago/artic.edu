require('dotenv').config();

const fs = require('fs').promises;
const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const generateRevManifestPlugin = require('./scripts/webpack/GenerateRevManifestPlugin');

class TimestampPlugin {
  apply(compiler) {
    compiler.hooks.done.tap('TimestampPlugin', (stats) => {
      const timestamp = new Date().toLocaleString();
      const hasErrors = stats.hasErrors();
      const emoji = hasErrors ? "❌" : "✅";
      setImmediate(() => {
        console.log(`${emoji} build ${hasErrors ? "failed" : "completed"} ${timestamp}`);
      });
    });
  }
}

const outputDir = path.resolve(__dirname, 'public', 'dist');

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
      if (err.code !== 'ENOENT') {
        console.error(`Failed to delete ${dirPath}:`, err);
      }
    }
  });

  await Promise.all(deletePromises);
}

module.exports = async () => {
  await cleanDirectories(['scripts', 'styles', 'images']);

  const isProd = process.env.NODE_ENV === 'production';
  const isCI = process.env.CI === '1';
  const useContentHash = process.env.USE_COMPILED_REVASSETS === 'true' || isProd;

  return {
    mode: isProd ? 'production' : 'development',
    entry: {
      app: ['./frontend/scss/app.scss', './frontend/js/app.js'],
      blocks3D: ['./frontend/js/blocks3D.js'],
      blocks360: ['./frontend/js/blocks360.js'],
      collectionSearch: ['./frontend/js/collectionSearch.js'],
      digitalExplorer: ['./frontend/js/digitalExplorer.js'],
      head: ['./frontend/js/head.js'],
      interactiveFeatures: ['./frontend/js/interactiveFeatures.js'],
      layeredImageViewer: ['./frontend/js/layeredImageViewer.js'],
      mirador: ['./frontend/js/mirador.js'],
      myMuseumTourBuilder: ['./frontend/js/myMuseumTourBuilder.js'],
      recaptcha: ['./frontend/js/recaptcha.js'],
      videojs: ['./frontend/js/videojs.js'],
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
      extensions: ['.js', '.jsx', '.scss', '.mjs'],
      fullySpecified: false,
      mainFields: ['browser', 'module', 'main'],
      fallback: {
        url: false,
      },
      alias: {
        'react': path.resolve(__dirname, 'node_modules/react'),
        'react-dom': path.resolve(__dirname, 'node_modules/react-dom'),
        'plyr$': path.resolve(__dirname, 'node_modules/plyr/dist/plyr.js'),
        'digital-explorer': path.resolve(__dirname, '../explorer/dist/digitalExplorer.cjs')      },
      modules: ['node_modules', path.resolve(__dirname, 'node_modules'),   path.resolve(__dirname, '../explorer/node_modules')],
    },
    plugins: [
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
      ...(useContentHash
        ? [
            new generateRevManifestPlugin({
              manifestPath: path.resolve(outputDir, 'rev-manifest.json'),
            }),
          ]
        : []
      ),
      new TimestampPlugin(),
    ],
    module: {
      rules: [
        {
          test: /\.m?jsx?$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: [
                [
                  '@babel/preset-env',
                  {
                    modules: false,
                    targets: {
                      browsers: ['last 2 versions', 'ie >= 11'],
                    },
                  },
                ],
                '@babel/preset-react',
              ],
              plugins: [],
              cacheDirectory: true,
            },
          },
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