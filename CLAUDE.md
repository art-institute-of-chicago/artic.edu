# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is **artic.edu** — the main website for the Art Institute of Chicago. It's a Laravel application built with the Twill 3.0 CMS, consuming data from the AIC's public API (`api.artic.edu`). The `develop` branch is the main branch.

## Requirements

- Use `nvm` to match `.nvmrc`
- Local development uses [AIC Docker](https://github.com/art-institute-of-chicago/aic-docker)

## Common Commands

- **Frontend** (`npm` scripts in `package.json`): run on the host machine, NOT inside Docker.
- **Backend** (`php artisan`, `composer` scripts in `composer.json`): run inside Docker.
  - `composer lint -- --report=full` for the full PHP CodeSniffer report
  - `php artisan twill:build` to compile CMS assets

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

### Frontend

Frontend conventions (behaviors, atomic design system) live in `.claude/rules/frontend-components.md`.

### CMS (Twill)

Twill handles content authoring. CMS navigation is configured in `AppServiceProvider->registerTwillNav`. Run `php artisan twill:build` after Twill upgrades.

## Off-limits Directories

Never read, edit, or create files inside `vendor/` or `node_modules/`. These are managed by Composer and npm respectively — any changes would be overwritten on the next install and could mask real dependency issues.
