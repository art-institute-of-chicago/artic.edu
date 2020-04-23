#!/usr/bin/env bash

DIR_SCRIPT="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
DIR_ROOT="$(realpath "$DIR_SCRIPT/..")"
DIR_BIN="$DIR_SCRIPT"

DIR_SRC="$DIR_ROOT/storage/app/tiles/src"
DIR_TMP="$DIR_ROOT/storage/app/tiles/tmp"
DIR_OUT="$DIR_ROOT/storage/app/tiles/out/iiif/static"

BIN_TILE="iiif-tile-seed"

# First param is the filename of the image inside `src`
if [ -z "$1" ]; then
  exit 1
fi

# Second param is the IIIF endpoint
if [ -z "$2" ]; then
  exit 1
fi

# You must build `go-iiif` and put it somewhere in $PATH
# https://stackoverflow.com/questions/6569478/detect-if-executable-file-is-on-users-path
[[ $(type -P "$BIN_TILE") ]] || exit 1

# tl;dr build steps on macOS:
# brew install go
# git clone https://github.com/go-iiif/go-iiif
# cd go-iiif
# make cli-tools

# https://stackoverflow.com/questions/7875540
cat > "$DIR_BIN/config.json" <<EOL
{
    "level": {
        "compliance": "2"
    },
    "graphics": {
        "source": {
            "name": "vips"
        }
    },
    "images": {
        "source": {
            "name": "Blob",
            "path": "file://${DIR_SRC}"
        },
        "cache": {
            "name": "Null"
        }
    },
    "derivatives": {
        "cache": {
            "name": "Blob",
            "path": "file://${DIR_TMP}"
        }
    }
}
EOL

mkdir -p "$DIR_TMP"

if [ -d "$DIR_TMP/$1" ]; then
  rm -r "$DIR_TMP/$1"
fi

"$BIN_TILE" \
    -refresh \
    -config-source "file://${DIR_BIN}" \
    -config-name 'config.json' \
    -endpoint "${2}" \
    -scale-factors '1,2,4,8,16' \
    --quality 'default' \
    --verbose \
    "file:///${1}"

if [ -d "$DIR_OUT/$1" ]; then
  rm -r "$DIR_OUT/$1"
fi

find "$DIR_TMP" -name "*.jpg" -print0 | while read -d $'\0' PATH_OLD; do
    PATH_REL="$(realpath --relative-to="$DIR_TMP" "$(dirname "$PATH_OLD")")"
    mkdir -p "$DIR_OUT/$PATH_REL" && cp "$PATH_OLD" "$DIR_OUT/$PATH_REL/default.jpg"
done
