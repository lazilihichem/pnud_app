---
paths:
  - 'app/Http/Requests/**'
---

# Requests

## One form request per controller method, authorization inside it
Requests live in `Http/Requests/<Module>/` (same module folder as the controller). Resource controllers get one request per method, always: `Index<Model>Request`, `Show<Model>Request`, `Store<Model>Request`, `Update<Model>Request`, `Destroy<Model>Request` (plus `Create`/`Edit` when those pages exist). Every invokable controller gets its own matching request (`PublishProjectController` → `PublishProjectRequest`), even with no input. Per-action authorization (may THIS user do THIS on THIS record) lives in the request's `authorize()`; there are no Policy classes and no route `can` middleware. The only route-level gates are the area and profile middleware of the routes rule (`EnsurePlatformAccess`, `EnsureAdminAccess`, `profile:<type>`), which decide who may enter a whole area; they never replace `authorize()`.

## SRS texts and French as source language
Screen texts the SRS quotes (error messages, labels) go in `lang/fr/<module>.php` AND `lang/ar/<module>.php` (e.g. `accounts.registration.email_taken`) and are returned from the request's `messages()` / `attributes()`; never hardcode them in PHP. See the i18n rule: the fallback locale is `en`, so both languages must define every key. Expose typed validated data to services through a request method with an array-shape PHPDoc (e.g. `Auth/StoreRegistrationRequest::registration()`), not `validated()` directly.

