// ### Scripts
// `gulp toolkit` - Generate a Toolkit using our own Sass down module https://code.area17.com/a17/node-sassdown.

module.exports = function(gulp, data, util, taskName){
  'use strict';

  var sassdown = require('@antoine_a17/a17-node-sassdown');
  var del = require('del');

  var srcPath = data.manifest.paths.source + data.manifest.paths.styles;
  var destPath = data.manifest.paths.toolkit;

  // sassdown options
  var options = {
      title: 'UI Toolkit',                            // Title of the toolkit
      assets: [
          data.manifest.paths.dist + 'styles/app.css',     // application CSS
          data.manifest.paths.dist + 'scripts/head.js',  // application JS
          data.manifest.paths.dist + 'scripts/app.js',   // application JS
      ],
      assetsRoot: 'styleguide',
      singlePage: true,                               // Single page styleguide
      verbose: false,                                 // Verbose mode
      commentStart: /\/\*\*\*/,                       // /***
      commentEnd: /\*\*\*\//,                         // ***/
      readme: null
  };

  // Task declaration
  gulp.task(taskName, ['styles', 'scripts'], function() {

    // clean destination before generating
    del(destPath + '**/*').then(function(paths) {
      //generate styleguide
      sassdown(srcPath, destPath, options);
    });
  });
};
