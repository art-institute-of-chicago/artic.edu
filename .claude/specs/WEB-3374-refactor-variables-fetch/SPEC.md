# Spec: Fetch Style Dictionary variables at build time instead of browser runtime

## Problem

`frontend/scss/_importsSetup.scss` currently does:

```scss
@import url($styles-service + '/storage/variables.css');
```

`$styles-service` is injected into every Sass compilation via `sass-loader`'s `additionalData` option in `webpack.config.js:167`, sourced from the `STYLES_SERVICE_URL` env var. Because the import target is a full URL, Sass can't inline it — it passes the `@import url(...)` straight through into the compiled CSS. That means **every visitor's browser** makes a live HTTP request to the Style Dictionary instance on every page load. This:

1. Exposes the Style Dictionary instance to production-level visitor traffic it wasn't meant to serve.
2. Adds a render-blocking network hop to every page load.

## Goal

Fetch the Style Dictionary output **once, at build time**, and inline its contents into the compiled `setup.css` bundle — the same way every other `@import` in the Sass pipeline already works. The webpack `entry` array itself doesn't need to change; entries just point at source files. The actual fix is a build-time fetch step plus switching from a URL import to a normal local-file import.

Longer-term, it'd be nice if the Style Dictionary service could emit an `.scss` file with `$variables` (for uniformity with the rest of the codebase's Sass vars) instead of a `.css` file with custom properties — but that's a change in whatever separate repo/service builds Style Dictionary's output, not this repo. The design below keeps that swap cheap: it'll be a one-line change to the fetch URL/output filename once that's available.

## Design

### 1. New fetch helper

`scripts/webpack/fetchStyleVariables.js` (same directory as the existing `GenerateRevManifestPlugin.js`, following that file's plain-module convention). Exports an async function that:

- Reads `process.env.STYLES_SERVICE_URL`.
- If unset, or if `fetch()` throws/returns non-OK: logs a `console.warn` and writes an empty (comment-only) file — the build continues without design tokens rather than failing. This matches the existing "don't import styles if env var is not set" precedent from the WEB-3374 commit history.
- On success: writes the response body verbatim to `frontend/scss/setup/_styleVariables.scss`.
- Uses Node's built-in global `fetch` (Node 24, already the repo's required version) — no new dependency.

### 2. Wire it into `webpack.config.js`

Inside the existing `module.exports = async () => { ... }` factory (`webpack.config.js:44`), call the new fetch helper alongside the existing `await cleanDirectories([...])` call (line 45), before the config object is returned.

This factory runs once per `webpack` / `webpack --watch` invocation — exactly the "fetch once when SCSS is built" behavior we want, and it covers `npm run dev`, `npm run build`, and `npm run build:dev` (used by CI) uniformly, with no new npm scripts needed.

Remove the now-unnecessary line from the `sass-loader` options (`webpack.config.js:167`):

```js
additionalData: `$styles-service: '${process.env.STYLES_SERVICE_URL}';`,
```

Nothing needs `$styles-service` as a Sass variable anymore.

### 3. Switch the Sass import

In `frontend/scss/_importsSetup.scss`, replace:

```scss
// Pull variables from the style service
@import url($styles-service + '/storage/variables.css');
```

with:

```scss
// Pull variables from the style service (fetched once at build time — see webpack.config.js)
@import 'setup/styleVariables';
```

This is now a normal Sass partial import, so `sass-loader`/`css-loader` inline its contents directly into the compiled `setup.css` — no runtime request from the browser.

### 4. Gitignore the generated file

Add `frontend/scss/setup/_styleVariables.scss` to `.gitignore`, since its content is fetched per-build from `STYLES_SERVICE_URL` and shouldn't be committed.

## Files touched

- `scripts/webpack/fetchStyleVariables.js` (new)
- `webpack.config.js` — call the fetch helper in the async config factory; drop the `additionalData` line
- `frontend/scss/_importsSetup.scss` — swap the `@import url(...)` for a plain local `@import`
- `.gitignore` — ignore the generated partial

## Verification

- Run `npm run dev` on the host with `STYLES_SERVICE_URL` set in `.env`; confirm `frontend/scss/setup/_styleVariables.scss` is created/populated and `public/dist/styles/setup*.css` contains the inlined custom properties (no `@import url(...)` left in the output).
- Unset `STYLES_SERVICE_URL` and rerun `npm run dev`; confirm the build still succeeds, a warning is logged, and the generated partial is empty rather than breaking the Sass compile.
- Open the built page in a browser and check the Network tab — there should no longer be a request to the Style Dictionary host at page load.
- Run `npm run build` to confirm the production path (used by CI's `npm run build:dev` step, which already has the `STYLES_SERVICE_URL` secret set) still fetches and builds correctly.

## Out of scope

- Changing the Style Dictionary service itself to emit SCSS instead of CSS. That lives in a separate repo/service and is a follow-up coordination item, not part of this change.
