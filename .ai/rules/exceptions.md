---
paths:
  - 'app/Exceptions/**'
---

# Exceptions

## Module-grouped domain exceptions that render themselves
Domain exceptions live in `App\Exceptions\<Module>\` (or `<Module>\<Area>\` for a sub-area, e.g. `Accounts\Auth\InvalidCredentialsException`) (e.g. Exceptions/Projects/ProjectAlreadyPublishedException) and extend `App\Exceptions\DomainException`. The base class's `render()` turns them into a translated (FR/AR) response: back with an error for Inertia requests, JSON otherwise. Services throw them; controllers never catch them.
Set `protected ?string $field` when the screen shows the error under an input (rendered as a validation error on that field, e.g. `code`, `email`); leave it null for a toast. Messages are translation keys; pass placeholders through `$this->replace` (e.g. `['seconds' => 30]`) and an HTTP status through `$this->status` (e.g. 429 for waits).
