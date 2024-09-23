const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const isProd = process.env.NODE_ENV === 'production';

// Can be set in Github action
const isCI = process.env.CI === '1'

// See: https://webpack.js.org/configuration/
module.exports = {
  mode: isProd ? 'production' : 'development',
  // Currently CSS isn't included in the Webpack build
  // This could be added later if the stdout webpack produces is preferred
  // For now this avoids the need for sass-loader, css-loader, and style-loader
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
    filename: './scripts/[name].js',
    path: path.resolve(__dirname, 'public', 'dist'),
    publicPath: '/dist/',
  },
  devtool: isProd ? 'source-map' : 'eval-source-map',
  optimization: {
    minimize: isProd && !isCI,
  },
  resolve: {
    extensions: ['.js', '.jsx', '.scss'],
    fallback: {
      "url": false,
    }
  },
  plugins: [
    // See: https://github.com/ProjectMirador/mirador/issues/3493
    new webpack.IgnorePlugin({
      resourceRegExp: /@blueprintjs\/(core|icons)/,
    }),
    ...(isCI ? [
      new webpack.IgnorePlugin({
        resourceRegExp: /closer-look/,
      }),
    ] : []),
    new MiniCssExtractPlugin({
      filename: 'styles/[name].css',
    }),
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
}
