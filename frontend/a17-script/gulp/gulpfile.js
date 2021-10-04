// ## Globals
const gulp = require('gulp');
const argv = require('minimist')(process.argv.slice(2));
const data = {
  plugins: {
    autoprefixer: require('gulp-autoprefixer'),
    changed: require('gulp-changed'),
    cleanCss: require('gulp-clean-css'),
    concat: require('gulp-concat'),
    flatten: require('gulp-flatten'),
    hub: require('gulp-hub'),
    if: require('gulp-if'),
    imagemin: require('gulp-imagemin'),
    notify: require('gulp-notify'),
    plumber: require('gulp-plumber'),
    rename: require('gulp-rename'),
    rev: require('gulp-rev'),
    revDeleteOriginal: require('gulp-rev-delete-original'),
    sass: require('gulp-sass')(require('sass')),
    sourcemaps: require('gulp-sourcemaps'),
    svgSprite: require('gulp-svg-sprite'),
    uglify: require('gulp-uglify'),
  }
};

const relativePath = __dirname.replace(process.cwd(), '.');
const path = require('path');
const utils = require('../utils');

// @see https://github.com/austinpray/asset-builder
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
// Path to task's files, defaults to gulp dir.
configPath: config.util.path.join(relativePath, './gulp_tasks', '*.{js,json,yml,yaml}'),

// Data passed into config task.
data:Object.assign(data, pack)
});
