---
paths:
  - 'app/Services/**'
---

# Services

## One service per model holds all business logic
All business logic, queries, transactions and side effects go in `App\Services\<Module>\<Model>Service` (e.g. Services/Projects/ProjectService), one per model. It holds both the CRUD methods and the extra actions (`publish()`, `transferOwnership()`…). Both the resource controller and the invokable controllers inject and call it. Services take validated data / models, never the Request, and throw domain exceptions on rule violations. A multi-step flow that spans several models (e.g. `Accounts/Auth/SignInService`: slow-down + status checks around sign-in) may get its own service next to the model services; session handling stays in the controller / Fortify action.

## Fortify actions delegate to services
Fortify keeps sign-in, password reset, e-mail verification and 2FA. `app/Actions/Fortify/*` keep the Fortify contract and validate their `$input`, then hand the validated data to the module service (`UserService::updatePassword()`…). Registration is NOT a Fortify feature: it is `Accounts/Auth/RegistrationResourceController` + `StoreRegistrationRequest` + `UserService::register()`. Any Fortify flow that needs real fields or a form request moves out of Fortify the same way.
