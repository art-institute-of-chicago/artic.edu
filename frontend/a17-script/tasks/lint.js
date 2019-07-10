const path = require('path');
const spawn = require('cross-spawn');
const utils = require('../utils');

const relativePath = __dirname.replace(process.cwd(), '.');

let useDefaultConfig =
  !utils.hasFile('.prettierrc') && !utils.hasFile('.prettierrc.js');

let config = useDefaultConfig
  ? ['--config', path.join(relativePath, '../config/.prettierrc')]
  : [];

let filesToApply = ['./tasks/*.js'];

var result = spawn.sync(
  utils.resolveBin('prettier'),
  [].concat(config, ['--write'], filesToApply),
  { stdio: 'inherit' }
);

process.exit(result.status);
