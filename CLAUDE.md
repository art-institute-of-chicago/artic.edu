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
- `curl` and `wget` are denied by project settings; use the WebFetch tool for HTTP requests (e.g. checking `api.artic.edu` responses).

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

## Source Control

`main` is what's in production; `develop` is the latest code ready for QA. Branch off `develop`, not `main`.

- **Branch names**: `[scope]/[optional-issue-number]-[short-description]`, where scope is usually `feature/`, `refactor/`, or `fix/`. Keep only related changes in a branch; unrelated changes go in a separate branch.
- **Commit titles**: imperative, present tense ("Change", not "Changed"), max 70 characters, ending with the Jira key(s) in square brackets, e.g. `Eager load dateRules [WEB-3492]` or `[WEB-943, CITI-4833]`. Use the body to explain *why*. If no ticket key is known, ask rather than inventing one.
- **Gen AI policy**: commit AI-generated changes as their own single commit, separate from any human edits to them, and put `[Gen-AI, <model>]` before the ticket key, e.g. `Improve handling of errors in API endpoints [Gen-AI, Claude-Sonnet-5] [WEB-3495]`. If a file is largely AI-generated, add a doc-style comment at the top noting so, with the developer's name (or git/artic ID), the date, and the model; skip the comment when generated and human code are too mixed to tease apart.
- **One commit, one change**: each commit should be a single, safely reversible change. Don't commit half-done work, and run the relevant tests before committing.
- **Never reference commit hashes in commit messages** — they change when rebasing.
- **Never commit secrets or server names.** When adding a config variable, add it to `.env.example`.
- **Write tests** for code changes.
- **One pull request, one concern**: no unrelated whitespace, typo, or renaming changes in a PR.

## Off-limits Directories

Never read, edit, or create files inside `vendor/` or `node_modules/`. These are managed by Composer and npm respectively — any changes would be overwritten on the next install and could mask real dependency issues.

Never edit `public/dist/` either. It's gitignored build output (webpack bundles and the SVG sprite compiled from `frontend/icons/`). Change the sources under `frontend/` and rebuild.
