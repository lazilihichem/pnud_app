---
paths:
  - 'app/Exceptions/**'
---

# Exceptions

## Module-grouped domain exceptions that render themselves
Domain exceptions live in `App\Exceptions\<Module>\` (e.g. Exceptions/Projects/ProjectAlreadyPublishedException) and extend `App\Exceptions\DomainException`. The base class's `render()` turns them into a translated (FR/AR) response: back with an error for Inertia requests, JSON otherwise. Services throw them; controllers never catch them.
