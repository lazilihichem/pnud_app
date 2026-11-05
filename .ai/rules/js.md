---
paths:
  - 'resources/js/**'
---

# Js

## Wayfinder links take the locale from URL defaults
Import public routes from `@/routes/public/…` and member routes from `@/routes/platform/…`. Do not pass `locale` to Wayfinder route or action functions: app.ts calls `setUrlDefaults({ locale })` from the shared `locale` prop on first load and on every navigation. Pass `locale` explicitly only to build a language-switch link to the other language. Pages under /platform must not rely on SSR; pages under /public must be SSR-safe (no window/document at module or setup level).
