#!/usr/bin/env bash

DIR_SCRIPT="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
DIR_ROOT="$(realpath "$DIR_SCRIPT/..")"
DIR_BIN="$DIR_SCRIPT"

DIR_SRC="$DIR_ROOT/storage/app/tiles/src"
DIR_OUT="$DIR_ROOT/storage/app/tiles/out/iiif/static"

BIN_TILE="vips"

# First param is the filename of the image inside `src`
if [ -z "$1" ]; then
  echo 'Missing filename'
  exit 1
fi

# You must ensure that `vips` is installed in somewhere in $PATH
# https://stackoverflow.com/questions/6569478/detect-if-executable-file-is-on-users-path
[[ $(type -P "$BIN_TILE") ]] || (echo 'Missing vips' && exit 1)

if [ -d "$DIR_OUT/$1" ]; then
  rm -r "$DIR_OUT/$1"
fi

mkdir -p "$DIR_OUT"

"$BIN_TILE" \
    dzsave \
    "$DIR_SRC/$1" \
    "$DIR_OUT/$1" \
    --layout iiif \
    --tile-size 256
