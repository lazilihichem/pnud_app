---
paths:
  - 'app/Http/Requests/**'
---

# Requests

## One form request per controller method, authorization inside it
Requests live in `Http/Requests/<Module>/` (same module folder as the controller). Resource controllers get one request per method, always: `Index<Model>Request`, `Show<Model>Request`, `Store<Model>Request`, `Update<Model>Request`, `Destroy<Model>Request` (plus `Create`/`Edit` when those pages exist). Every invokable controller gets its own matching request (`PublishProjectController` → `PublishProjectRequest`), even with no input. All authorization lives in the request's `authorize()`; there are no Policy classes and no route `can` middleware.

## SRS texts and French as source language
Screen texts the SRS quotes (error messages, labels) go in `lang/fr/<module>.php` (e.g. `accounts.registration.email_taken`) and are returned from the request's `messages()` / `attributes()`; never hardcode them in PHP. French is the app locale and the fallback (`config/app.php`), so a key missing from `lang/ar` shows in French until the client supplies Arabic. Generic rule messages come from `lang/fr/validation.php`. Expose typed validated data to services through a request method with an array-shape PHPDoc (e.g. `RegisterAccountRequest::registration()`), not `validated()` directly.

