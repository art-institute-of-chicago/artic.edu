// ### Icons
// `gulp icons` - Creates SVG sprite and updates styles/setup/_icons.scss
// with icon classes and dimensions based on filename
// @see https://github.com/jkphl/svg-sprite/blob/master/docs/configuration.md

var svgSprite    = require('gulp-svg-sprite');

module.exports = function(gulp, data, util, taskName){
  'use strict';

  var $    = data.plugins,
      path = data.manifest.paths;

  gulp.task('icons', function() {
    return gulp.src(path.source + path.icons +'*.svg')
     .pipe($.if(!data.enabled.failStyleTask, $.plumber({
              errorHandler: function(err){
                $.notify.onError({
                    title:    "Icon Error",
                    message:  "Error: <%= error.message %>",
                    sound:    "Basso"
                })(err);
                this.emit('end');
              }
            })))
      .pipe(svgSprite({
        shape: {
          id: {
            generator: 'icon--%s'
          }
        },
        mode: {
          symbol: {
            dest: '.',
            prefix: '.%s',
            dimensions: '%s',
            sprite: path.dist + path.icons +'icons.svg',
            render: {
              scss: {
                template: (path.iconsTemplate !== undefined && path.iconsTemplate !== false) ? path.iconsTemplate : __dirname.replace(process.cwd(), '.') + '/iconsTemplate.scss',
                dest: path.source + path.styles +'/setup/_icons'
              }
            }
          }
        }
    }))
    .pipe($.notify({
      onLast: true,
      title: "Icons Compiled",
      message: "All icons compiled"
    }))
    .pipe(gulp.dest('.'));
  });
};
