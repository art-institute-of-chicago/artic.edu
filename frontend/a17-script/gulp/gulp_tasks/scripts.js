// ### Scripts
// `gulp scripts` - Runs webpack

var webpack = require('webpack');
var webpackStream = require('webpack-stream');
var path = require('path');
const notifier = require('node-notifier');

module.exports = function(gulp, data, util, taskName) {
  var scriptsPath = './' + data.manifest.paths.source + data.manifest.paths.scripts;
  var $ = data.plugins;

  gulp.task(taskName, function() {
    return (
      gulp
      .src(scriptsPath + '_.js')
      .pipe(webpackStream({
        devtool: data.isProduction ? 'nosources-source-map' : 'cheap-module-eval-source-map',
        entry: {
          app: scriptsPath + 'app.js',
          head: scriptsPath + 'head.js',
          interactiveFeatures: scriptsPath + 'interactiveFeatures.js',
          blocks360: scriptsPath + 'blocks360.js',
          mirador: scriptsPath + 'mirador.js',
          virtualTour: scriptsPath + 'virtualTour.js',
          blocks3D: scriptsPath + 'blocks3D.js',
          collectionSearch: scriptsPath + 'collectionSearch.js',
          videojs: scriptsPath + 'videojs.js',
          recaptcha: scriptsPath + 'recaptcha.js',
        },
        stats: {
          errorDetails: true,
        },
        output: {
          filename: '[name].js',
          chunkFilename: '[name].[contenthash].bundle.js', // WEB-2014
          path: path.resolve(__dirname, 'dist/scripts'),
          publicPath: '/dist/scripts/'
        },
        module: {
          rules: [
            {
              test: /\.js$/,
              exclude: /node_modules\/(?!(@antoine_a17|@gulp-sourcemaps|@area17|)\/).*/,
              loaders: 'buble-loader',
              options: {
                target: {
                  ie: 11,
                  safari: 9,
                  chrome: 55,
                  edge: 14
                }
              }
            },
            {
              test: /\.css$/i,
              use: ['css-loader'],
            },
          ],
        },
        plugins: [ new webpack.optimize.LimitChunkCountPlugin({
          maxChunks: 1,
        }) ],
      }, webpack, (err, stats) => {
        if (stats.compilation.errors.length === 0) {
          notifier.notify({
            'title': 'JS compiled',
            'message': Object.keys(stats.compilation.assets).join(', '),
          });
        }
      }))
      .on('error', function handleError(err) {
        $.notify.onError({
            title:    "JS Error",
            message:  "Error: <%= error.message %>",
            sound:    "Basso"
        })(err);
        this.emit('end'); // Recover from errors
      })
      .pipe(gulp.dest(data.manifest.paths.dist + 'scripts'))
    );
  });
};
