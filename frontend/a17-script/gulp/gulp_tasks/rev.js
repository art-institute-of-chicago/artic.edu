// ### Write to rev manifest
// If there are any revved files then write them to the rev manifest.
// @see https://github.com/sindresorhus/gulp-rev

module.exports = function(gulp, data, util, taskName) {
  'use strict';

  var $            = data.plugins,
      distPath     = data.manifest.paths.dist;

  // Task declaration
  gulp.task(taskName, ['styles', 'scripts', 'icons'], function() {
    if (data.enabled.rev) {
      return gulp.src(
          [
            distPath + '**/*.css',
            distPath + '**/*.js',
            distPath + '**/*.svg',
            '!' + distPath + '**/*.bundle.js', // WEB-2014
          ],
          {
            base: distPath
          }
        )
        .pipe($.rev())
        .pipe($.revDeleteOriginal())
        .pipe(gulp.dest(distPath))
        .pipe($.rev.manifest({
          merge: true
        }))
        .pipe(gulp.dest(distPath));
    }
  });
};
