---
paths:
  - 'routes/**'
---

# Routes

## Two localized areas: /public/{locale} and /platform/{locale}
Every page lives in one of two groups in routes/web.php, each prefixed with `{locale}` (`App\Enums\Locale`: fr|ar, SRS FR-06):
- `public/{locale}/…`, names `public.*`: public portal for visitors. The only area that is server-rendered (SSR), set in AppServiceProvider::configureSsr().
- `platform/{locale}/…`, names `platform.*`, `auth` middleware: member spaces of the signed-in FR-01 roles (Entrepreneur, Accompagnateur, Formateur, Citoyen). Client-rendered.
The admin back-office will get its own separate `/admin` prefix (not yet built). Fortify auth pages (login, register, password, 2FA, verification) stay unprefixed. Never add a page outside these areas. `SetLocale` (web group) applies the locale, sets `URL::defaults(['locale'])` and strips the parameter, so controllers never receive `$locale` and `route()` calls never pass it. URLs without a locale are redirected by `RedirectToLocaleController` (account language → cookie → fr); keep its catch-all routes last.
Inside each area, group routes per ERD module with a `// <Module>` comment (Route::resource() + the module's invokable routes), as in the controllers rule.
