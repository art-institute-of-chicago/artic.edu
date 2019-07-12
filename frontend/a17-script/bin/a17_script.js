#!/usr/bin/env node
'use strict';

const _ = require('lodash');
const path = require('path');
const spawn = require('cross-spawn');
const chalk = require('chalk');

const processArgv = _.toArray(process.argv);
const executor = processArgv[0];
const ignoredBin = processArgv[1];
const task = processArgv[2];
const args = processArgv.slice(3);

function attemptResolve() {
  try {
    var _require;

    return (_require = require).resolve.apply(_require, arguments);
  } catch (error) {
    return null;
  }
}

function runTask() {
	let relativePath = path.join(__dirname, '../tasks', task);
	let resolvedPath = attemptResolve(relativePath);

	if(!resolvedPath) {
		throw new Error(`"${task}" is not a valid task`);
	}

	let result = spawn.sync(executor, [resolvedPath].concat(args), {stdio: 'inherit'});
	
	if(result.signal) {

	} else {
		process.exit(result.status);
	}

}


if (task) {
	runTask();
} else {
	console.log('\nPlease pass in a task you want to run.\n');
}