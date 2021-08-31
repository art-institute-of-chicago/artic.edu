'use strict';

const fs = require('fs');
const path = require('path');
const readPkgUp = require('read-pkg-up');
const which = require('which');

let _readPkgUp$sync = readPkgUp.sync({
  cwd: fs.realpathSync(process.cwd())
});

let pkgPath = _readPkgUp$sync.path;

let appDirectory = path.dirname(pkgPath);

let fromRoot = function () {
  for (var _len = arguments.length, p = Array(_len), _key = 0; _key < _len; _key++) {
    p[_key] = arguments[_key];
  }

  return path.join.apply(path, [appDirectory].concat(p));
};

let hasFile = function () {
  return fs.existsSync(fromRoot.apply(undefined, arguments));
};

//copy from kcd-scripts
let resolveBin = function (modName) {
  var _ref = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {},
      _ref$executable = _ref.executable,
      executable = _ref$executable === undefined ? modName : _ref$executable,
      _ref$cwd = _ref.cwd,
      cwd = _ref$cwd === undefined ? process.cwd() : _ref$cwd;

	var pathFromWhich = void 0;

  try {
    pathFromWhich = fs.realpathSync(which.sync(executable));
  } catch (_error) {
    // Ignore _error
	}

  try {
		var modPkgPath = require.resolve(`${modName}/package.json`);
    var modPkgDir = path.dirname(modPkgPath);

    var _require = require(modPkgPath),
				bin = _require.bin;

    var binPath = typeof bin === 'string' ? bin : bin[executable];
    var fullPathToBin = path.join(modPkgDir, binPath);
    if (fullPathToBin === pathFromWhich) {
      return executable;
    }
    return fullPathToBin.replace(cwd, '.');
  } catch (error) {
    if (pathFromWhich) {
      return executable;
    }
    throw error;
  }
};

let hereRelative = function(p) {
	return path.join(__dirname, p).replace(process.cwd(),'.');
};

module.exports = {
	appDirectory,
	hasFile,
	fromRoot,
	resolveBin,
	hereRelative
};
