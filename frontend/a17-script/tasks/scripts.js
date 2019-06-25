const path = require('path');
const spawn = require('cross-spawn');
const utils = require('../utils');
const relativePath = __dirname.replace(process.cwd(), '.');

let result = spawn.sync(
  utils.resolveBin('gulp'),
  [].concat(['scripts'],['--cwd'],[process.cwd()],['--gulpfile'], [path.join(relativePath, '../gulp/gulpfile.js')]),
  { stdio: 'inherit' }
);

process.exit(result.status);