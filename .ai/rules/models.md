---
paths:
  - 'app/Models/**'
  - 'app/Enums/**'
  - 'database/migrations/**'
  - 'database/factories/**'
---

# Models

## Account type = polymorphic profile, no role column
Every user has exactly one profile, held by the user: `users.profilable_type` + `users.profilable_id` (unique pair). `App\Enums\ProfileType` lists the types (`admin`, `entrepreneur`, `accompagnateur`, `formateur`, `citoyen`); its values are the morph-map aliases and `modelClass()` maps each to its model in `App\Models\Accounts\` (`AdminProfile`, `EntrepreneurProfile`, `AccompagnateurProfile`, `TrainerProfile`, `CitoyenProfile`). Administrators and super administrators share `admin_profiles` (`is_super_admin`).
- `$user->profile` is the morphTo; `$user->type` reads the `ProfileType` from `profilable_type`, and setting it (`$user->type = ProfileType::Citoyen`) writes `profilable_type`. Create the profile first, then `$user->profile()->associate($profile)`.
- Profile tables have no `user_id`; a profile reaches its account through `user()` (morphOne). Data specific to one kind of account goes on its profile, not on `users`. Admin scopes (ERD AdminScope) attach to `admin_profiles`.
- Use `$user->type`, `isAdministrator()`, `isSuperAdmin()`; never compare `profilable_type` strings by hand.
- Factories: `User::factory()->profile(ProfileType::Formateur, [...profile attributes])`, `->admin(super: true)`; the default is an active entrepreneur.

## Enforced morph map
`AppServiceProvider::configureMorphMap()` enforces the morph map (profiles + `user`): polymorphic columns store aliases, never class names. Every new polymorphic owner (a model with media, comments…) must be added there, or saving it throws.

## Where each profile lands
The home of each profile is decided in ONE place: the `match` on `$user->type` in `Accounts/Auth/RedirectToHomeController` (`/{locale}/platform`, `platform.home`). Sign-in, registration, the authenticator-app step, Fortify's home and the « already signed in » redirect all send users to `platform.home`; never pick a profile home anywhere else.
