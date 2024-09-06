const path = require('path');
const webpack = require('webpack');
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
      // Transpile JavaScript files using Babel
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: ['babel-loader'],
      },
    ],
  },
}
