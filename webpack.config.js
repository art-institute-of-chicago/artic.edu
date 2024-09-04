const path = require('path');
const webpack = require('webpack');
const isProd = process.env.NODE_ENV === 'production';

// Set in Github action
const isCI = process.env.CI === '1'

module.exports = {
  mode: isProd ? 'production' : 'development',
  entry: {
    app: ['./frontend/js/app.js'],
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
    extensions: ['.js', '.jsx'],
    fallback: {
      "url": false,
    }
  },
  plugins: [
    // See: https://github.com/ProjectMirador/mirador/issues/3493
    new webpack.IgnorePlugin({
      resourceRegExp: /@blueprintjs\/(core|icons)/,
    }),
  ],
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: ['babel-loader'],
      },
    ],
  },
}
