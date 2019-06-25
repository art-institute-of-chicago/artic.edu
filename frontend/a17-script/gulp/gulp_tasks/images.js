// ### Images
// `gulp images` - Run lossless compression on all the images.

module.exports = function(gulp, data, util, taskName){
  'use strict';

  var $ = data.plugins;

  gulp.task(taskName, function() {
    return gulp.src(data.manifest.globs.images)
      .pipe($.imagemin({
        progressive: true,
        interlaced: true,
        svgoPlugins: [{removeUnknownsAndDefaults: false}, {cleanupIDs: false}]
      }))
      .pipe(gulp.dest(data.manifest.paths.dist + 'images'))
      .pipe($.notify({
        onLast: true,
        title: "Images Compressed",
        message: "All images compressed"
      }));
  });
};
