// ### Watch
// `gulp watch` - Use BrowserSync to proxy your dev server and synchronize code
// changes across devices. Specify the hostname of your dev server at
// `manifest.config.devUrl`. When a modification is made to an asset, run the
// build step for that asset and inject the changes into the page.
// @see: http://www.browsersync.io

module.exports = function(gulp, data, util, taskName){
  'use strict';

  var path = data.manifest.paths;

  gulp.task('watch', function() {
    gulp.watch([path.source + path.styles +'**/*'], ['styles']);
    gulp.watch([path.source + path.scripts +'**/*'], ['scripts']);
    gulp.watch([path.source + path.icons +'**/*'], ['icons']);
    gulp.watch([path.source + 'images/**/*'], ['images']);
    gulp.watch([path.source + 'manifest.json'], ['build']);
  });
};
