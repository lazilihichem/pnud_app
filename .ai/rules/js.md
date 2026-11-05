---
paths:
  - 'resources/js/**'
---

# Js

## Wayfinder links take the locale from URL defaults
`@/i18n` sets Wayfinder's `{locale}` URL default before any page module runs, so never pass `locale` to Wayfinder route or action functions, except to build a link to the same page in another language (use `useLocale().alternateLocales`). Public routes have no name prefix (`import { home } from '@/routes'`); member routes come from `@/routes/platform/…`, back-office routes from `@/routes/admin/…`. Pages under /{locale}/platform and /admin must not rely on SSR; pages in routes/public.php are server-rendered and must be SSR-safe (no window/document at module or setup level).

## All interface text goes through vue-i18n
Never hardcode interface text in a component: use `const { t } = useI18n()` and keys from `resources/js/i18n/locales/fr.json` (the master schema), with the same key in `ar.json`. Layout titles/descriptions in `defineOptions({ layout })` are keys too. `npm run check` (check-keys) fails on a key that is missing in a locale, extra, or unused. Backend texts (validation, SRS messages, e-mails) stay in `lang/{fr,ar}/*.php`, and every key must exist in both: the fallback locale is `en`, which has no translations, so a missing Arabic key shows as a raw key.
