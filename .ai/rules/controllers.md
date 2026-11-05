---
paths:
  - 'app/Http/Controllers/**'
---

# Controllers

## Module-grouped resource + invokable controllers
Group by ERD module (same folders as app/Models/<Module>: Accounts, Reference, Projects, Accompaniment, Participation, Academy, Content, Messaging, Operations). CRUD for a model goes ONLY in `Http/Controllers/<Module>/<Model>ResourceController` (e.g. Projects/ProjectResourceController). Every other endpoint touching that model is its own single-action invokable controller in the same folder, named Verb+Model (`PublishProjectController`, `SuspendUserController`). Controllers hold no business logic or queries: resolve the request, call the model's service, return the Inertia/redirect response. Never catch domain exceptions in controllers. Routes go in the area route file they belong to (see the routes rule), grouped per module (Route::resource() + invokable routes).

## Endpoints on the signed-in user's own account
Settings-style endpoints acting on the current user (profile, password, security, account deletion) are invokable controllers in `Accounts/` (`EditProfileController`, `UpdatePasswordController`, `DeleteAccountController`…) calling `UserService`, not methods on `UserResourceController`. That one is reserved for admin CRUD on users.
