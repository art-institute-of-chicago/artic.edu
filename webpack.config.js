const path = require('path')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const isProd = process.env.NODE_ENV === 'production'
// Set in Github action
const isCI = process.env.CI === '1'

module.exports = {
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
  module: {
    rules: [
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
            loader: 'postcss-loader',
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true,
            },
          },
        ],
      },
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        type: 'asset/resource',
        generator: {
          filename: 'images/[name][ext]',
        },
      },
      {
        test: /\.(woff2?|eot|ttf)$/,
        type: 'asset/resource',
        generator: {
          filename: 'fonts/[name][ext]',
        },
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'styles/[name].css',
    }),
  ],
}
