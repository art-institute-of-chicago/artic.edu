---
paths:
  - "frontend/js/**"
  - "frontend/scss/**"
  - "resources/views/components/**"
---

# Frontend components

- `frontend/js/behaviors/` — Component behaviors using `@area17/a17-helpers`
  - `core/` contains all behaviors that are common across all areas of the website
  - Other subdirectories contain behaviors that are specific to functionality that's only found in some areas of the website
- `frontend/scss/` — Atomic design system: `atoms/`, `molecules/`, `organisms/`
- `resources/views/components/` — Blade files associated with our atomic design system: `atoms/`, `molecules/`, `organisms/`

Note that we define each level of components in our atomic design system as follows:

* _Tokens_: A property definition. Does not define a DOM element, has no visual presense of its own, but is a named design decision. We use two types of tokens in our codebase:

  1) primitive tokens which are raw values, e.g., `$color__black--81`, and
  2) semantic tokens, which are the primitive values mapped to a design intent, e.g., `$color__dark-mode__bg--primary`.
* _Atom_: Single-purpose root element. Cannot contain other atoms.Typically represented by a single DOM element, but may compose a small number of elements that comprise a small-level of functionality.
* _Molecule_: A named UI pattern with one clear responsibility. May contain other atoms.
* _Organism_: Self contained feature or page section. A simple block might be a complete organism.
