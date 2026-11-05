---
paths:
  - 'resources/js/**'
---

# Js

## Wayfinder links take the locale from URL defaults
`@/i18n` sets Wayfinder's `{locale}` URL default before any page module runs, so never pass `locale` to Wayfinder route or action functions, except to build a link to the same page in another language (use `useLocale().alternateLocales`). Public routes have no name prefix (`import { home } from '@/routes'`); member routes come from `@/routes/platform/…`, back-office routes from `@/routes/admin/…`. Pages under /{locale}/platform and /admin must not rely on SSR; pages in routes/public.php are server-rendered and must be SSR-safe (no window/document at module or setup level).

## Texts
All interface text goes through vue-i18n: see the i18n rule (`.ai/rules/i18n.md`).
