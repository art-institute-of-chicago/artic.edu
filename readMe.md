# New England Journal of Medicine

This development repository for the AIC build, uses as its foundation the AREA 17 FE boilerplate and the AREA 17 CMS Toolkit.

Before editing any files here, please install [EditorConfig](https://code.area17.com/a17/fe-boilerplate/wikis/dotfiles-editorconfig) to your text editor, enable [jshint](https://code.area17.com/a17/fe-boilerplate/wikis/dotfiles-jshintrc) and enable [scss-lint](https://code.area17.com/a17/fe-boilerplate/wikis/dotfiles-scss-lint-yml).

## Local Compile

In order to compile SCSS/JS files, you will need Node and Gulp running on your system. Typically we install Node and NVM via the package manger Homebrew. Once those are installed, within this directory you will need to:

```
$ npm install
```

If you've never used Gulp, you'll likely need the CLI:

```
npm install gulp-cli
```

And then for initial compile:

```
$ gulp build
```

Or for continuous work, with 'watch' task running, just:

```
$ gulp
```

To generate UI toolkit pages:

```
$ gulp toolkit
```
