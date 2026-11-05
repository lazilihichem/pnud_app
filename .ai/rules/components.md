---
paths:
  - 'resources/js/components/**'
  - 'resources/js/pages/**'
  - 'resources/js/layouts/**'
---

# Components

## UI stack: reka-ui + Tailwind CSS only
Every interactive primitive (dialog, select, tabs, popover, checkbox, OTP input…) comes from reka-ui, styled with Tailwind 4 utilities and the ESS design tokens. Do not add another UI kit, headless library or CSS framework, and do not hand-roll a primitive reka-ui already provides (focus trap, roving tabindex, ARIA tabs…). Icons: `@lucide/vue`.

## ESS design tokens (resources/css/app.css)
The demo's `css/tokens.css` is translated into Tailwind theme colours: brand `ess-*` (`bg-ess-blue`, `text-ess-ink`, `border-ess-line`, `bg-ess-mist`…), soft tags `tag-*` / `tag-*-fg` (notes, statuses), shadows `shadow-ess-xs…lg` (only for what floats), radii `rounded-lg` (6px controls), `rounded-xl` (10px cards), `rounded-button` (5px), heights `h-control` (44px fields/buttons) and `h-chip` (36px). The shadcn-vue semantic colours (`primary`, `border`, `ring`, `muted`…) are mapped onto these tokens, so `ui/` components already wear the ESS palette. Use tokens, never raw hex values in components (except the few footer tones the demo defines outside its tokens). The dark theme is a DERIVED palette (not validated by the client): it only redefines the `--ess-*` variables under `.dark`; components need no `dark:` variants except where contrast requires it (text on lightened buttons). Custom token names must be registered in `cn()`'s tailwind-merge config (`resources/js/lib/utils.ts`) so they override shadcn defaults.

## Three layers: reka-ui → components/ui → components/basic
- `components/ui/<name>/`: shadcn-vue primitives on reka-ui, treated as vendor code. Added only with the shadcn-vue CLI (`components.json` points it here); never edited by hand.
- `components/basic/<name>/`: our layer, one folder per primitive with an `index.ts`. It starts as `export * from '@/components/ui/<name>'`; to adapt a primitive to the ESS design (variants, sizes, tokens, RTL), add a wrapper `.vue` in that folder (e.g. `basic/dialog/Dialog.vue` wrapping `ui/dialog`) and export it from `index.ts` instead. Import paths never change.
- Everything else (pages, layouts, feature components) imports primitives ONLY from `@/components/basic/<name>`: never from `@/components/ui/…` and never from `reka-ui` directly. A primitive with no basic folder yet gets one first.
- Restyled so far (wrappers): `button` (variants default/accent/outline/secondary/ghost/link/destructive/destructive-solid/on-blue, `block`, `diamond` = the brand's green diamond for a public primary action), `input`, `label`, `checkbox`, `tabs`, `input-otp`, `alert` (`tone`: info/success/warning/danger/neutral), `card` (`floating`). `native-select` is a basic primitive with no shadcn counterpart: the demo deliberately uses the native `<select>`.
- Adding a shadcn-vue primitive: `npx shadcn-vue@2 add <name>`, then revert any `package.json` / lock change it makes (it bumps dependencies and has added a bogus `cn` package) and fix its `cn` import to `@/lib/utils`. Dependency changes need approval.

## Feature components live in a logical folder, never at the components root
Any component that is not a basic primitive goes in a folder named after the page or area it belongs to, mirroring how the screens group visually: `components/auth/`, `components/settings/`, `components/layout/` (app shell, navigation), `components/dashboard/`, later `components/projects/`, `components/profile/`… A component shared by several areas goes in a function folder instead: `components/forms/` (InputError, PasswordInput), `components/typography/` (Heading, TextLink), `components/dialogs/`… Name files in PascalCase after what they are in their area (`profile/ProfileDialog.vue`, not `MyDialog.vue`). Nothing sits directly in `resources/js/components/`.

## Layouts
- `layouts/PublicLayout.vue`: the public portal shell (skip link, `components/public/PublicHeader`, breadcrumb band, `PublicFooter`). Public pages and auth pages use it.
- `layouts/AuthLayout.vue`: auth pages inside the public shell. Page options: `title` / `description` (keys), `breadcrumb` (shorter key), `icon` (`mail` | `key` | `lock` | `shield`), `bare` (the page draws its own card, e.g. the connexion tabs in `components/auth/AuthCard.vue`).
- `layouts/AppLayout.vue` (+ `settings/Layout.vue`): the signed-in platform; its intranet design (demo `intranet/`) comes with the member-space modules.
- Public links to pages not built yet use `components/public/navigation.ts` (paths relative to `/{locale}`), not hardcoded URLs.
- Static images from the demo go in `public/images/` (logo, `partners/`).

## The demo is the visual reference, not the code reference
`../Pnud-demo` (static HTML; serve it with `python3 -m http.server` from its root) is the UI reference: tokens in `css/tokens.css`, rules in `DESIGN.md`, components in `pages/styleguide.html` and `css/components.css`. Rebuild what it shows with basic components; do not copy its markup, inline styles or JS. Never carry over its demo-only behaviour: « Démonstration » hint boxes, the « Cas à explorer » bar and `?cas=`/`?etat=`/`?expiree=`… switches, the role picker on the code step, magic e-mails/passwords, seeded accounts, client-side sessions or client-only timers (every expiry and rate limit is enforced server-side). Note: account registration is the « Créer un compte » tab of `pages/connexion.html`; `pages/inscription.html` is the training sign-up (FR-20).
