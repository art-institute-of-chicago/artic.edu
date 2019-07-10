// ### Fonts
// `gulp fonts` - Grabs all the fonts and outputs them in a flattened directory
// structure. See: https://github.com/armed/gulp-flatten

module.exports = function(gulp, data, util, taskName){
  'use strict';

  var $ = data.plugins;

  gulp.task('fonts', function() {
    return gulp.src(data.manifest.globs.fonts)
     .pipe($.if(!data.enabled.failStyleTask, $.plumber({
          errorHandler: function(err){
            $.notify.onError({
                title:    "Fonts Error",
                message:  "Error: <%= error.message %>",
                sound:    "Basso"
            })(err);
            this.emit('end');
          }
        })))
      .pipe($.flatten())
      .pipe(gulp.dest(data.manifest.paths.dist + 'fonts'))
      .pipe($.notify({
        onLast: true,
        title: "Fonts Complete",
        message: "All fonts flattened and moved"
      }));
  });
};
