---
paths:
  - 'routes/**'
---

# Routes

## Every page lives under /{locale}, in one of four route files
`routes/web.php` only holds the root redirect, the passkey well-known endpoint and the `{locale}` group (fr|ar, `config('app.supported_locales')`, pattern set in AppServiceProvider). Inside it, each area has its own file and default middleware:
- `routes/platform.php` → `/{locale}/platform/…`, names `platform.*`, `EnsurePlatformAccess`: member spaces of signed-in users. Client-rendered.
- `routes/admin.php` → `/{locale}/admin/…`, names `admin.*`, `EnsureAdminAccess`: back-office. Client-rendered.
- `routes/auth.php` → `/{locale}/…`, `guest`: the application's own auth pages next to Fortify's (registration FR-01, e-mail code step FR-02). Client-rendered.
- `routes/public.php` → `/{locale}/…`, no name prefix (`home`), `HandlePublicRequests`: public portal, the only server-rendered (SSR) area.
Fortify's own pages are registered under `/{locale}` by `config/fortify.php` (`prefix`). Platform and admin stay registered before auth and public so a future public catch-all cannot capture them. Area access rules belong in the area middleware's `handle()`, not in each route.

## Locale handling
`SetLocale` (web group, prioritised before auth) resolves the locale (URL → account language → 12-month `locale` cookie → session → browser → `app.locale`), sets `URL::defaults(['locale'])`, keeps Fortify's home/logout paths localized and strips the parameter, so controllers never receive `$locale` and `route()` calls never pass it. A `{locale}` URL is a language choice (FR-06): it refreshes the cookie and the signed-in user's account language.

## Group by module inside each file
Inside each route file, group routes per ERD module with a `// <Module>` comment (Route::resource() + the module's invokable routes), as in the controllers rule.
