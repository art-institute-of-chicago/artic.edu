#!/usr/bin/env bash

# Let's assume some defaults, if these are not yet set
# http://supervisord.org/subprocess.html#subprocess-environment
# https://github.com/libvips/libvips/wiki/Build-for-Ubuntu
if [ -z "$VIPSHOME" ]; then
    export VIPSHOME=/usr/local/vips
fi

if [[ $LD_LIBRARY_PATH != *"$VIPSHOME/lib"* ]]; then
    export LD_LIBRARY_PATH=$LD_LIBRARY_PATH:$VIPSHOME/lib
fi

if [[ $PATH != *"$VIPSHOME/bin"* ]]; then
    export PATH=$PATH:$VIPSHOME/bin
fi

if [[ $PKG_CONFIG_PATH != *"$VIPSHOME/lib/pkgconfig"* ]]; then
    export PKG_CONFIG_PATH=$PKG_CONFIG_PATH:$VIPSHOME/lib/pkgconfig
fi

if [[ $MANPATH != *"$VIPSHOME/man"* ]]; then
    export MANPATH=$MANPATH:$VIPSHOME/man
fi

if [ $PYTHONPATH != "$VIPSHOME/lib/python2.7/site-packages" ]; then
    export PYTHONPATH="$VIPSHOME/lib/python2.7/site-packages"
fi

# Directory variables for convenience
DIR_SCRIPT="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
DIR_ROOT="$(realpath "$DIR_SCRIPT/..")"
DIR_BIN="$DIR_SCRIPT"

DIR_SRC="$DIR_ROOT/storage/app/tiles/src"
DIR_OUT="$DIR_ROOT/storage/app/tiles/out"

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

# We are creating directories two levels deep, so we can upload just the inner one
mkdir -p "$DIR_OUT/$1"

"$BIN_TILE" \
    dzsave \
    "$DIR_SRC/$1" \
    "$DIR_OUT/$1/$1" \
    --layout iiif \
    --tile-size 256
