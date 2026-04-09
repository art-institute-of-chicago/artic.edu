# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is **artic.edu** — the main website for the Art Institute of Chicago. It's a Laravel 11 application built with the Twill 3.0 CMS, consuming data from the AIC's public API (`api.artic.edu`). The `develop` branch is the main branch.

## Requirements

- PHP 8.2
- Node 24.13.0 (lts/krypton) — use `nvm` to match `.nvmrc`
- NPM 11.6.2
- PostgreSQL 17
- Local development uses [AIC Docker](https://github.com/art-institute-of-chicago/aic-docker)

## Common Commands

### Frontend (run on host machine, NOT inside Docker)

```bash
npm ci               # Install dependencies
npm run build        # Production build (svg-sprite + webpack)
npm run dev          # Watch mode for local development
```

### Backend (run inside Docker)

```bash
php artisan test                    # Run full test suite (parallel)
php artisan test --filter TestName  # Run a single test
composer lint                       # PHP CodeSniffer (summary)
composer lint -- --report=full      # PHP CodeSniffer (full report)
composer format                     # Auto-fix linting errors (PHP CS Fixer)
composer analyze                    # PHPStan static analysis
php artisan twill:build             # Compile CMS assets
```

### Running tests

Tests use a separate PostgreSQL database configured in `.env.testing`. Run `php artisan test` inside Docker.

## Architecture

### Data Flow: Two Model Systems

The most important architectural concept is that **two types of models coexist**:

1. **Eloquent models** (`app/Models/`) — CMS-managed content stored in PostgreSQL (pages, articles, events, etc.)
2. **API pseudo-models** (`app/Models/Api/`) — Fake Eloquent models that fetch from `api.artic.edu` (artworks, exhibitions, etc.)

The `BaseApiModel` (`app/Libraries/Api/Models/BaseApiModel.php`) implements Eloquent-like behavior (mutators, scopes, pagination, relationships) against the read-only API. An `AicGrammar` class (`app/Libraries/Api/Builders/Grammar/AicGrammar.php`) translates query builder calls into API parameters.

Many Eloquent models mix in `HasApiModel` to **augment** API records with CMS data — so an artwork page renders data from both sources.

Key behaviors:
- `app/Libraries/Api/Models/Behaviors/HasApiCalls.php` — HTTP calls to the API
- `app/Libraries/Api/Models/Behaviors/HasAugmentedModel.php` — merging API + Eloquent data
- `app/Models/Behaviors/HasApiRelations.php` / `HasApiModel.php` — linking Eloquent to API records

See `docs/apiModels.md` for detailed usage examples and `docs/images.md` for image handling.

### Backend Structure

- `app/Http/Controllers/` — 40+ controllers; `API/` subdirectory for JSON endpoints
- `app/Libraries/` — Domain services: `Api/` (query builder, models), `Search/` (collection search), `ExploreFurther/`, `RecentlyViewedService/`
- `app/Repositories/` — Repository pattern for data access (both Eloquent and API)
- `app/Presenters/` — View presenters for template logic
- `routes/web.php` — Public pages; `routes/api.php` — JSON API (v1); `routes/twill.php` — CMS admin; `routes/kiosk.php` — Kiosk mode

### Frontend Structure

- `frontend/js/app.js` — Main JS entry point
- `frontend/js/behaviors/` — Component behaviors using `@area17/a17-helpers`
  - `core/` contains all behaviors that are common across all areas of the website
  - Other subdirectories contain behaviors that are specific to functionality that's only found in some areas of the website
- `frontend/icons/` — SVG source files, auto-compiled into sprites via `npm run svg-sprite`
- Compiled assets land in `public/dist/`
- `frontend/scss/` — Atomic design system: `atoms/`, `molecules/`, `organisms/`
- `resources/views/components/` — Blade files associated with our atomic design system: `atoms/`, `molecules/`, `organisms/`

Note that we define each level of components in our atomic design system as follows:

* _Tokens_: A property definition. Does not define a DOM element, has no visual presense of its own, but is a named design decision. We use two types of tokens in our codebase:

  1) primitive tokens which are raw values, e.g., `$color__black--81`, and
  2) semantic tokens, which are the primitive values mapped to a design intent, e.g., `$color__dark-mode__bg--primary`.
* _Atom_: Single-purpose root element. Cannot contain other atoms.Typically represented by a single DOM element, but may compose a small number of elements that comprise a small-level of functionality.
* _Molecule_: A named UI pattern with one clear responsibility. May contain other atoms.
* _Organism_: Self contained feature or page section. A simple block might be a complete organism.

Special JS bundles: `mirador.js` (IIIF viewer), `myMuseumTourBuilder.js` (tour builder), `recaptcha.js`.

### CMS (Twill)

Twill handles content authoring. CMS navigation is configured in `config/twill-navigation.php`. Run `php artisan twill:build` after Twill upgrades.

### Key Config Files

- `config/aic.php` — Custom AIC application settings
- `config/galleries.php` — Gallery configuration
- `config/api.php` — API client configuration
- `.env.example` — All available environment variables and feature flags

## Off-limits Directories

Never read, edit, or create files inside `vendor/` or `node_modules/`. These are managed by Composer and npm respectively — any changes would be overwritten on the next install and could mask real dependency issues.
