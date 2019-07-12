// ## Globals
const gulp           = require('gulp'),
argv           = require('minimist')(process.argv.slice(2)),
plugins        = require('gulp-load-plugins')(),
data           = { plugins: plugins };

const relativePath = __dirname.replace(process.cwd(), '.');
const path = require('path');
const utils = require('../utils');

/* To test locally for bower_components folder. Reguired by manifest.js,
but project doesn't use bower */
// var fs = require('fs');

// try {
// fs.accessSync('./bower_components', fs.F_OK);
// } catch (e) {
// fs.mkdir('./bower_components');
// }

// See https://github.com/austinpray/asset-builder

let manifestPath = !utils.hasFile('./frontend/manifest.json') ? path.join(relativePath,'../config/manifest.json') : './frontend/manifest.json';

data.manifest = require('asset-builder')(manifestPath, { bower:false });

// CLI options
data.enabled = {
// Enable static asset revisioning when `--production`
rev: !!argv.production,
// Disable source maps when `--production`
maps: !argv.production,
// Fail styles task on error when `--production`
failStyleTask: !!argv.production,
// Fail due to JSHint warnings only when `--production`
failJSHint: !!argv.production,
// Strip debug statments from javascript when `--production`
stripJSDebug: !!argv.production
};

data.isProduction = !!argv.production;

// Load multiple gulp tasks using globbing patterns.
// @see https://github.com/adriancmiranda/load-gulp-config
var config = require('load-gulp-config');

// Specifics of npm's package.json handling.
// @see https://docs.npmjs.com/files/package.json
var pack = config.util.readJSON('package.json');

config(gulp, {
// path to task's files, defaults to gulp dir.
configPath: config.util.path.join(relativePath, './gulp_tasks', '*.{js,json,yml,yaml}'),

// data passed into config task.
data:Object.assign(data, pack)
});
