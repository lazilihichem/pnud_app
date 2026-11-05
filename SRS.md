# Software Requirements Specification (SRS)
**Project Name:** Plateforme Digitale ESS — national Social and Solidarity Economy platform (Algeria)
**Client:** PNUD Algérie (UNDP), with the Ministère du Travail, de l'Emploi et de la Sécurité Sociale (MTESS) — programme funded by the European Union
**Prepared by:** Trybe (SARL AIVOT)
**Date:** 20 October 2026
**Version:** 1.1

---

## 1. Project Overview

### 1.1 Background

The United Nations Development Programme in Algeria (PNUD Algérie) implements, with the Ministère du Travail, de l'Emploi et de la Sécurité Sociale (MTESS) and funding from the European Union, the programme « L'Économie Sociale et Solidaire au service d'une inclusion économique durable des jeunes entrepreneures et entrepreneurs en Algérie ». The programme pursues two effects: a stronger ecosystem for the Social and Solidarity Economy (ESS) — regulation, institutional capacity, support structures — and more ESS enterprises created and developed, in particular by young people and women.

Within this programme, Trybe (SARL AIVOT) is commissioned to design, build and hand over a national digital ESS platform. The platform is meant to become the single entry point to the ESS in Algeria: a public portal that informs and connects, and a members' area where project holders, support structures, trainers and citizens work together. After delivery, the platform will be transferred to a national government institution; PNUD remains Trybe's counterpart during design and build.

A first specification (SRS v1.0, "Livrable 1", July 2026) was followed by an interactive front-end prototype ("demo V0") covering the public portal, the member space of every role and the back-office. The programme management unit (UGP) reviewed the public portal of the demo and returned written comments on 8 October 2026 (« Plateforme Web ESS — Feedbacks UGP V0 »).

**Basis of this document.** This specification describes the platform as demonstrated in demo V0, corrected by the UGP feedback. Sources, in order of precedence: (1) UGP feedback V0, 8 October 2026; (2) demo V0 — public portal, member spaces, back-office; (3) internal meeting notes of 23 September; (4) SRS « Livrable 1 » (July 2026), Note de cadrage v3 and the Terms of Reference (TDR). Version 1.1 incorporates the decisions taken on the questions of version 1.0, whose files are archived in `srs/archive/`. Twenty points remain open with the UGP: they are listed in the Q&A file (QA-SRS.md), numbered Q1–Q20 as in the document « Questions à l'UGP v1.0 »; where a requirement depends on one of them, it cites the number and states the assumption used meanwhile. This document supersedes SRS « Livrable 1 ».

### 1.2 Problem Statement

- Information on the ESS in Algeria is scattered across ministries, public agencies, support structures and donors. There is no single, trusted reference explaining what the ESS is, which organisations belong to it, and which public policies and financing sources support it.
- Young entrepreneurs — especially young women, often coming from informal or unstable work — struggle to tell whether their idea fits the ESS, to find the support structure that matches their project's maturity, to identify financing they are eligible for, to access training, and to follow a structured path from idea to financed project.
- Support structures, institutions and funders have no shared space to receive, qualify and follow project holders. Each works from its own lists, beneficiaries are lost between structures, and nobody sees the pipeline as a whole.
- Trainers have no common reference to deliver ESS training to a consistent standard.
- Citizens who want to help local initiatives — by volunteering or mentoring — have no channel to reach them.
- Programme leadership lacks consolidated, current data to steer the programme and report to its funder.

### 1.3 Goals

- Make the ESS understood and recognised as a credible economic model by the Algerian public, entrepreneurs and institutions.
- Increase the number of young people — young women in particular — who turn an ESS idea into a structured, supported project.
- Reduce the time and effort an entrepreneur needs to reach the support structure and financing source suited to the project's stage.
- Strengthen coordination between institutions, support structures and funders around shared beneficiaries.
- Raise the ESS competence of entrepreneurs, support professionals and trainers to a common standard.
- Increase citizen involvement in local ESS initiatives.
- Give the programme reliable, up-to-date evidence on its pipeline and results, for steering and for reporting to its funder.
- Leave the national institution with an ecosystem tool it can sustain after transfer, proven first with a pilot group of 200 beneficiary users.

---

## 2. Scope

### 2.1 In Scope

**Public portal (French and Arabic)**
- Homepage
- ESS presentation (« Découvrir l'ESS ») and key figures
- Public catalogue of ESS projects
- Accompaniment and financing directory
- Training catalogue (« Académie »)
- Citizen participation: surveys and consultations, volunteering, mentoring
- Resource centre and webinar replays
- News, events and media library (« Médias »)
- Site search, contact form, newsletter subscription
- Accessibility controls

**Accounts and access**
- Registration by profile, sign-in with two-factor authentication, password recovery, user profile

**Member spaces**
- Entrepreneur space: project submission, project dossier, project team
- Accompaniment matching between projects and accredited accompagnateurs
- Citizen space: contribution offers to projects
- Learning space: training registration and waiting lists, online courses, training quizzes
- Trainer space: qualification, pedagogical kit, training authoring, agenda
- Messaging, notifications and announcements

**Back-office**
- User and administrator accounts
- Moderation of projects, accreditations, trainings, contributions and reported conversations
- Project phase progression and PDF export of project dossiers
- Editing and review of public-portal content: pages, news, events, resources, replays, surveys, media, directories, reference lists
- Inbox for contact-form messages
- Platform settings
- Work-queue dashboard, statistics and data exports
- Activity history

### 2.2 Out of Scope

- Native mobile applications (iOS / Android) — the platform is a responsive web application only.
- Any payment processing: crowdfunding, donation collection, fees.
- Hosting of live sessions: live trainings and webinars run on external tools; the platform stores and displays the joining link only.
- SCORM packages, certificates and learning analytics beyond the training quizzes.
- Data exchange with ANADE, ANEM, ANGEM, NESDA, CNAC or other institutional information systems — deferred to a later version.
- Forums, discussion groups and other public social-network features.
- Help-desk / ticketing system and internal knowledge base.
- Interactive map of support structures — replaced by a categorised list (UGP feedback; confirmation pending, Q17).
- Composition and sending of newsletters, and an archive of past newsletters — the platform collects subscribers only.
- A dedicated role and features for funders and businesses, such as publishing calls for funding — possible in a later version.
- A per-action permission matrix for administrators — scopes are defined per back-office section.
- File attachments in messaging — documents go through the project dossier.
- Notification preferences set by each user — notifications are configured platform-wide by Super-administrators.
- Automatic translation — Arabic content is supplied by the client.
- Production of editorial content (texts, figures, photographs, translations) — supplied by the client; Trybe drafts the first version of the homepage, ESS presentation and Participation texts for the UGP to validate.
- Hosting procurement and infrastructure costs — procured separately by MTESS.
- Non-software services listed in the TDR (hosting specification, administrator training, user guides, 200-user pilot, maintenance) — covered by the project plan, not by this specification.

---

## 3. User Roles & Permissions

| Role | Description | Key Permissions |
|---|---|---|
| Visitor | Anyone browsing the public portal without signing in. | View published public content; search; subscribe to the newsletter; send a contact message; answer anonymous surveys; register for in-person or hybrid trainings (pending, Q5) and for events without an account; create an account. |
| Entrepreneur (« Entrepreneur / Organisation ESS », porteur·se de projet) | A person or ESS organisation — association, cooperative, foundation, mutual, social enterprise, self-help group, individual entrepreneur — carrying a project. | Create, submit, edit, withdraw and transfer own projects; upload dossier documents; invite team members; apply to shortlisted accompagnateurs and answer their proposals; ask to end an accompaniment early; accept, refuse and close citizen contributions; register for trainings; message accompagnateurs and contributors. |
| Team member | An Entrepreneur account invited onto another entrepreneur's project. | View the project record; take part in the project's conversations; become owner when the owner transfers the project. |
| Accompagnateur (« Accompagnateur·rice ») | A support professional or structure — incubator, accelerator, public agency, network — that coaches projects. Must hold a platform accreditation (agrément), valid 2 years. | Request and renew accreditation. Once accredited: view the oriented projects of their accredited phases, propose accompaniment, accept or refuse applications, close an accompaniment with its outcome, ask to end one early, message the projects they support. Their capacity is set by administrators. |
| Trainer (« Formateur·rice ») | A trainer delivering Académie trainings. Must pass the qualification and be validated. | Follow the qualification course and test; once validated, read the pedagogical kit; create trainings and submit them for validation; request deletion of a training; view their agenda. |
| Citizen (« Citoyen·ne ») | A member of the public who wants to support ESS projects. | Browse projects; offer volunteering, mentoring or a donation pledge (Q4) to projects; close an accepted contribution; answer nominative surveys; register for trainings; message an entrepreneur once an offer is accepted. |
| Administrator (« Administrateur·rice ») | A programme staff member operating the back-office within an assigned scope. | Within scope: review and orient projects, confirm phase completion, shortlist accompagnateurs and set their capacity, validate accounts, accreditations and trainings, create catalogue trainings, write or review and publish public content, run surveys, send announcements and messages, answer contact messages, handle reported conversations, view statistics and export data. |
| Super-administrator (« Super administrateur·rice ») | Platform owner — two accounts, one for PNUD and one for the receiving national institution. | Everything an Administrator can do, across all scopes; invite, suspend and scope administrators; restore the other Super-administrator's access; change account e-mail addresses after an identity check; edit platform settings and reference lists; view the full activity journal. |

---

## 4. Functional Requirements

**Conventions used in this section**
- Screen labels, button labels and statuses are quoted in French exactly as displayed. The Arabic interface uses approved translations of the same labels.
- Required fields are marked with an asterisk on screen. Text inputs are trimmed of leading and trailing spaces before validation; a field containing only spaces counts as empty. Character limits count Unicode characters.
- Dates are displayed DD/MM/YYYY and times HH:MM (24-hour), Algeria time (UTC+1).
- Numbers are written with Western digits (1 254) in both French and Arabic.
- Every refusal, suspension or cancellation reason is a text of 10–500 characters, mandatory.
- Unless an FR states otherwise: documents accept PDF, DOCX, XLSX and PPTX up to 10 MB; images accept JPG, PNG and WebP up to 5 MB; the file type is checked on content, not only on extension. Every uploaded file is scanned for malware; while the scanner is unavailable, the file is held in quarantine, visible only to its uploader as « En cours de vérification », until scanned.
- Every list screen has a loading state, an empty state with an explanatory message, and an error state with a "Réessayer" action.
- "Notify" means a notification on the channels set for its type in the platform settings (FR-69c); the default channels are listed in FR-51.
- Wilaya, sector, legal form, stage, filière, thematic and category values come from the reference lists of FR-69b.
- "Source" lines trace each requirement to the demo screen and/or the feedback item it comes from; « v1.0 Q&A Qn » cites the archived question that led to a change.
- Requirement numbers of version 1.0 are kept; requirements added in version 1.1 carry a letter suffix (e.g. FR-40a). « Qn » alone refers to an open question of QA-SRS.md.

---

### Module 1 — Accounts & Access

#### FR-01 — Account Registration

**Description:** A visitor can create an account by choosing a profile — Entrepreneur / organisation ESS, Accompagnateur, Formateur or Citoyen — and completing the fields that profile requires.
*Source: demo `pages/connexion.html` (tab « Créer un compte »), `js/auth.js`; back-office account statuses (`js/sadmin-users-data.js`); v1.0 Q&A Q40, Q42, Q67, Q132.*

**Main Flow:**
1. Visitor clicks "S'inscrire" in the header or "Créer un compte" anywhere on the portal and lands on the « Créer un compte » tab.
2. Visitor selects "Je suis *"; the form displays the fields for that profile.
3. Visitor completes the fields, sets and confirms a password, ticks the terms checkbox and submits.
4. System validates the input, creates the account with the initial status of the profile, sends a verification e-mail and signs the user in.
5. System redirects to the role's home: Entrepreneur → tableau de bord; Accompagnateur → tableau de bord with the invitation to request accreditation (FR-36); Formateur → « Ma qualification » (FR-46); Citoyen → tableau de bord citoyen.

**Data & Format:**
- Je suis: select | "Entrepreneur / organisation ESS", "Accompagnateur", "Formateur", "Citoyen" | required
- Nom complet: text | free text | required, 2–100 characters
- E-mail: text | valid e-mail address | required, max 254 characters, unique across all accounts (case-insensitive)
- Organisation: text | free text | optional, max 150 characters
- Wilaya: select | wilaya reference list | required (users living outside Algeria: Q10)
- Fonction / spécialité (Accompagnateur only): text | free text | required, max 150 characters
- Profil LinkedIn (Formateur only): URL | https://… | optional, max 300 characters
- Formation / diplômes (Formateur only): text | free text | required, max 300 characters
- CV (Formateur only): file | PDF, DOC, DOCX | required, max 5 MB
- Mot de passe: password | masked, with show/hide toggle | required, 8–64 characters, at least one letter and one digit
- Confirmer le mot de passe: password | masked | required, identical to Mot de passe
- « J'accepte les conditions d'utilisation… »: checkbox | links to the terms of use and the privacy policy | required

**Rules & Constraints:**
- One account per e-mail address. Holding two profiles with one address is not possible.
- Initial account status: Entrepreneur and Citoyen → « Actif »; Accompagnateur → « Inactif » until an accreditation request is submitted (FR-36); Formateur → « Qualification à passer » (FR-46).
- The verification link is valid for 24 hours. Until the address is verified, the user can sign in but cannot submit anything (project, accreditation request, contribution offer, training for validation); a banner offers "Renvoyer l'e-mail", limited to 3 sends per hour. The verification e-mail is queued and retried if the mail service is unavailable; its 24-hour validity starts at actual delivery. Entering a sign-in code received by e-mail (FR-02) also verifies the address.
- The profile chosen at registration cannot be changed by the user.
- The system stores the date and time of consent and the version of the terms accepted.
- Switching "Je suis" clears the fields specific to the previous profile; they are never submitted.

**Edge Cases:**
- E-mail already registered → "Un compte existe déjà avec cette adresse." with the links "Se connecter" and "Mot de passe oublié ?".
- Required fields missing → each is highlighted and the message "Veuillez remplir les champs obligatoires." appears above the button.
- CV in another format or over 5 MB → "Format accepté : PDF, DOC, DOCX — 5 Mo maximum."; the file is rejected before upload.
- Passwords differ → "Les mots de passe ne correspondent pas."
- Verification link expired → the page offers "Renvoyer l'e-mail de vérification".
- Network failure on submit → entered values are kept (except passwords) and an error with "Réessayer" is displayed.

---

#### FR-02 — Sign-in and Two-Factor Authentication

**Description:** A registered user can sign in with e-mail and password, confirmed by a code sent to their e-mail address, and lands on the home page of their role.
*Source: demo `pages/connexion.html` (tab « Connexion »); account record badges « Double authentification active / inactive »; TDR (authentification multifacteurs); v1.0 Q&A Q15, Q69, Q71, Q72, Q132.*

**Main Flow:**
1. User opens the « Connexion » tab, enters e-mail and password, optionally ticks "Se souvenir de moi", and clicks "Se connecter".
2. System checks the credentials and the account status.
3. System sends a 6-digit code to the account's e-mail address and asks for it. This applies to every account, administrators included.
4. On success, the user is redirected to the page originally requested when it is a page of the platform, or else to the home of the role stored on the account.
5. An account created with a provisional password (FR-55) must set a new password before any other page opens.

**Data & Format:**
- E-mail: text | e-mail address | required, max 254 characters
- Mot de passe: password | masked | required
- Se souvenir de moi: checkbox | — | optional; ignored for Administrator and Super-administrator accounts
- Code de vérification: text | exactly 6 digits, sent by e-mail | required at every sign-in; valid 5 minutes from delivery; single use

**Rules & Constraints:**
- A wrong e-mail or password returns one generic message: "Adresse e-mail ou mot de passe incorrect."
- After 3 consecutive failures from the same device or IP address, further attempts from it are slowed down — a wait that doubles at each failure, up to 15 minutes — and a challenge is shown. The account itself is never locked; its owner receives an alert e-mail when attempts on it are being slowed down.
- 3 wrong codes invalidate the current code. "Renvoyer le code" becomes available 60 seconds after a send, maximum 3 sends per 15 minutes.
- Entering a code received by e-mail marks the address as verified (FR-01).
- The role is the one stored on the account. Role choice on the client side, automatic demo sign-in and the « Changer de vue » switcher exist only in the prototype and must not exist in the product.
- Status at sign-in: « Suspendu » → sign-in refused with "Votre compte est suspendu. Contactez l'équipe de la plateforme."; « Refusé » → sign-in refused with "Votre inscription n'a pas été retenue." followed by the reason (the refusal e-mail offers « Contester la décision », FR-54); « Inactif », « Qualification à passer » and « En attente de validation » → sign-in allowed with restricted access (FR-36, FR-46).
- "Se souvenir de moi" keeps a non-administrator session for 30 days on that browser; once it expires, the code is asked again at the next sign-in.
- The return page after sign-in is accepted only if it is an address of the platform; any other address leads to the home of the role.

**Edge Cases:**
- Attempts slowed down → "Trop de tentatives. Patientez N secondes avant de réessayer."
- Code expired → "Code expiré." with "Renvoyer le code".
- Mail service unavailable → the code e-mail is queued and retried, its 5-minute validity starting at delivery; the screen shows "L'envoi du code prend plus de temps que prévu." No bypass is offered.
- Signed-in user opens the sign-in page → redirected to the home of their role.
- Link carrying an outside return address (e.g. `?next=https://…`) → the address is ignored and the user lands on the home of their role.

---

#### FR-03 — Password Reset

**Description:** A user who forgot the password can set a new one through a single-use link sent by e-mail.
*Source: demo link « Mot de passe oublié ? » on `pages/connexion.html` (no screen built); SRS « Livrable 1 » FR-04; v1.0 Q&A Q74, Q132.*

**Main Flow:**
1. User clicks "Mot de passe oublié ?" and enters the account e-mail.
2. System always displays "Si un compte existe pour cette adresse, un e-mail vous a été envoyé." and, when an account exists and is neither suspended nor refused, nor an administrator invitation not yet accepted, e-mails a reset link.
3. User opens the link and enters and confirms a new password.
4. System saves it, ends every open session of the account, sends a confirmation e-mail and redirects to the sign-in page.

**Data & Format:**
- E-mail: text | e-mail address | required, max 254 characters
- Nouveau mot de passe: password | masked | required, 8–64 characters with at least one letter and one digit; for Administrator and Super-administrator accounts 12–64 characters with at least 3 of 4 character families (lowercase, uppercase, digit, symbol)
- Confirmer le mot de passe: password | masked | required, identical to the new password

**Rules & Constraints:**
- The link is valid for 60 minutes and can be used once; requesting a new link invalidates the previous one.
- Maximum 3 requests per e-mail address per hour.
- The new password must differ from the current one.
- A successful reset clears the slow-down applied to failed sign-ins (FR-02), and opening a valid reset link marks the e-mail address as verified. The e-mail code still applies at the next sign-in.
- The reset e-mail is queued and retried if the mail service is unavailable; its 60-minute validity starts at actual delivery.

**Edge Cases:**
- Unknown e-mail → the same neutral message; no e-mail is sent.
- Link expired or already used → "Ce lien n'est plus valide." with "Demander un nouveau lien".
- New password identical to the current one → "Choisissez un mot de passe différent de l'actuel."
- Suspended or refused account, or administrator invitation not yet accepted → the neutral message is displayed and no reset e-mail is sent; an invited administrator uses the invitation (FR-55).

---

#### FR-04 — Sessions and Sign-out

**Description:** The system keeps a user signed in only while active and lets the user sign out from any page.
*Source: demo account menu (« Mon espace ESS », « Déconnexion »), member-space top bar (« Mon profil », « Déconnexion »); v1.0 Q&A Q75.*

**Main Flow:**
1. Once signed in, the header shows an account button with initials and name; its menu offers "Mon espace ESS" (home of the role), "Mon profil" and "Déconnexion".
2. User chooses "Déconnexion" and confirms.
3. System ends the session on the server and redirects to the public homepage.

**Data & Format:**
- Session: server-side session identifier | stored in an HttpOnly, Secure cookie | expires after 30 minutes of inactivity, or 30 days with "Se souvenir de moi" (non-administrator roles only)

**Rules & Constraints:**
- 2 minutes before inactivity expiry, a dialog offers "Rester connecté".
- An upload in progress counts as activity: the session does not expire while a file is being sent; an interrupted upload resumes where it stopped, and a completed upload is kept even if the session expired meanwhile.
- A password change, a password reset or a suspension ends every session of the account immediately.
- Member-space pages open only with a valid session of an authorised role; any other role receives an "Accès réservé" page (HTTP 403). This replaces the demo behaviour where several member pages accept any role.
- The mobile menu shows "Se connecter" and "Créer un compte" only when the user is signed out.

**Edge Cases:**
- Session expires while a form is being filled → on submit the user is sent to sign-in and then returned to the form; wizard steps already saved are kept (FR-32).
- User signs out in one browser tab → other tabs show the sign-in page at their next action.
- Signed-out user opens a member-space link → sign-in page, then redirect to that link.
- Account suspended during a session → the next request ends the session and displays the suspension message.

---

#### FR-05 — Profile, Password Change and Personal History

**Description:** A signed-in user can view and update their profile, change their password and e-mail address, and read the history of decisions concerning them.
*Source: demo `intranet/profil.html` (tabs « Informations » / « Historique », password form, « Mon agrément » card); v1.0 Q&A Q15, Q76, Q126, Q131.*

**Main Flow:**
1. User opens "Mon profil".
2. The « Informations » tab shows Nom complet, E-mail, Organisation, Wilaya, Téléphone and Profil; Formateur also sees Profil LinkedIn, Formation / diplômes and CV; Accompagnateur also sees the « Mon agrément » card with its status (FR-36).
3. User clicks "Modifier", edits the editable fields and saves; or completes the password form; or enters a new e-mail address and confirms it from the link sent to that address.
4. The « Historique » tab lists dated events concerning the user — submissions, decisions and their reasons — most recent first.

**Data & Format:**
- Nom complet: text | free text | required, 2–100 characters
- Organisation: text | free text | optional, max 150 characters
- Wilaya: select | wilaya reference list | required
- Téléphone: text | 0XXXXXXXXX or +213XXXXXXXXX | optional
- Profil LinkedIn (Formateur): URL | https://… | optional, max 300 characters
- Formation / diplômes (Formateur): text | free text | required, max 300 characters
- CV (Formateur): file | PDF, DOC, DOCX | required, max 5 MB
- Nouvelle adresse e-mail: text | e-mail address | max 254 characters, unique across all accounts
- Mot de passe actuel: password | masked | required to change the password or the e-mail address
- Nouveau mot de passe: password | masked | required, same rules as FR-03
- Confirmer le nouveau mot de passe: password | masked | required, identical

**Rules & Constraints:**
- The profile type is read-only.
- A new e-mail address takes effect only once the link sent to it is opened (valid 24 hours from delivery); a notice is sent to the former address. A user who has lost access to the former mailbox contacts the team, and a Super-administrator changes the address after an identity check (FR-53).
- Changing the password requires the current password, ends every other session and sends a confirmation e-mail.
- When a validated Trainer replaces the CV or edits « Formation / diplômes », administrators are notified and can re-examine the account (FR-54).
- For an accredited Accompagnateur, changes to Organisation or Wilaya are sent to an administrator and apply only once approved (FR-53); meanwhile Entrepreneurs keep seeing the accredited values (FR-37).
- The history is read-only and shows only events concerning the user.

**Edge Cases:**
- Wrong current password → "Mot de passe actuel incorrect."
- New e-mail address already used → "Cette adresse est déjà utilisée par un compte de la plateforme."
- Confirmation link for the new address expired → the change is cancelled and the former address stays active.
- User leaves the page with unsaved changes → confirmation dialog "Quitter sans enregistrer ?".
- History empty → "Aucun événement pour le moment."

---

### Module 2 — Public Portal: Navigation, Home & Footer

#### FR-06 — Main Navigation and Language Switch

**Description:** Every public page shows the same header with the main sections, search, language switch and account access; member spaces and the back-office offer the same language switch in their top bar.
*Source: demo `js/layout.js` (header), member-space top bar in `js/intranet.js` (« FR / ع »); UGP feedback V0, « Académie — Participation citoyenne : ressortir comme rubrique à part »; TDR (interface FR/AR); v1.0 Q&A Q77, Q118.*

**Main Flow:**
1. Visitor sees the logo (link to the homepage), the menu "Découvrir l'ESS", "Projets", "Accompagnement", "Académie", "Participation", "Ressources", "Médias", a search icon, the language switch "FR" / "ع", and "S'inscrire" (signed out) or the account menu (signed in).
2. Visitor selects an item; the current section is highlighted, and sub-pages highlight their parent section.
3. Visitor clicks "ع"; the same page reloads in Arabic, laid out right-to-left.
4. At widths of 768 px and below, a menu button opens a full-screen menu with the same items plus "Contact", the language choice "Français" / "العربية", and the sign-in links or account menu.
5. In member spaces and the back-office, the top bar shows the same "FR" / "ع" switch; switching reloads the current screen in the chosen language.

**Data & Format:**
- Langue: enum | fr, ar | carried in the URL path (/fr/…, /ar/…) and remembered in a preference cookie for 12 months
- Langue du compte: enum | fr, ar | set at registration; updated at each sign-in to the language then in use, and each time a signed-in user switches language
- Search query (mobile search field): text | free text | 2–100 characters, sent to the search page as ?q=

**Rules & Constraints:**
- "Académie" links directly to the training catalogue; "Participation" is a top-level item (UGP). No item has a drop-down.
- In Arabic, every interface label is translated and the layout is mirrored. Content with no Arabic version is shown in French with the notice « Ce contenu n'est disponible qu'en français » (in Arabic). Who translates the content, and whether Arabic must be complete at launch, is pending (Q8).
- Switching language keeps the user on the equivalent page of the same item.
- A main-menu item whose page is unpublished (FR-64) is hidden until the page is published again.
- At sign-in, the language used just before signing in becomes the account language; it applies on every device and to e-mails and notifications (FR-51).
- Menus open and close with the keyboard; Esc closes them. The first focusable element on every page is the skip link "Aller au contenu".

**Edge Cases:**
- The equivalent page has no Arabic version → French version with the notice.
- User switches language on a member-space screen with unsaved changes → confirmation "Quitter sans enregistrer ?" before the screen reloads.
- Arabic labels longer than French → menu items wrap without overlapping at 1024 px.
- Session expired → the header shows "S'inscrire" again at the next page load.
- Search icon used on desktop → the search page opens with focus in the search field.

---

#### FR-07 — Homepage

**Description:** The homepage presents the platform, its promises, the ESS, its figures, the accompaniment journey, featured projects, the word of the National Director, ESS news, the FAQ and the participation and newsletter band, in the order set by the UGP.
*Source: demo `index.html`; UGP feedback V0, « Page d'accueil », bandeaux 1–10 and « Avec le soutien de »; v1.0 Q&A Q3, Q25, Q78.*

**Main Flow:**
1. **Hero:** eyebrow "Programme national ESS · Algérie", title, paragraph presenting the platform (replacing the current paragraph, UGP; first draft by Trybe, validated by the UGP), buttons "Découvrir l'ESS" (→ FR-10) and "Explorer les projets" (→ FR-12); the background photograph rotates.
2. **« Nos objectifs »**, placed right after the hero (UGP): title and lead rewritten as 3 promises to the users of the platform; each promise has a card with an optional figure (free text, independent of FR-11) and a link "En savoir plus" (Accompagnement, Projets, Académie).
3. **« Qu'est-ce que l'ESS ? »**: paragraph presenting the ESS and its principles (replacing the current one, UGP) and an image; no partner logos (UGP).
4. **« L'ESS en chiffres »**, placed after « Qu'est-ce que l'ESS ? » (UGP): the key figures of FR-11 beside a map of Algeria marking the wilayas where the programme has projects; each marker shows the wilaya's name on hover, keyboard focus or tap, and a caption lists the wilayas covered (e.g. "10 wilayas couvertes : Alger · Oran · …").
5. **« Accompagnement »**: title "Un accompagnement à chaque étape de votre parcours" (UGP: « parcours » instead of « projet »); 4 steps — "Faites le point", "Trouvez une structure", "Faites-vous accompagner", "Financez votre projet" — with button "Trouver mon accompagnement" (→ FR-15).
6. **« Ils font l'ESS »**: « Projets du mois » (FR-14) and link "Tous les projets".
7. **« Un mot de la Directrice Nationale du programme ESS »** (UGP correction): quote, photo, name and function (content pending, Q16).
8. **« Actu de l'ESS »**: merged agenda and news (UGP recommendation, FR-26), with link "Toute l'actualité".
9. **« FAQ »**: orientation questions in an accordion.
10. **« Participer » / « Newsletter »** band and footer (FR-08, FR-09).

**Data & Format:**
- Hero title: text | FR and AR | required, max 60 characters
- Hero paragraph: text | FR and AR | required, max 300 characters
- Hero photographs: image | JPG or WebP, at least 1400 px wide, delivered at max 400 KB | 1–3 images, alternative text required; real programme photographs pending (Q14)
- Promise: title max 60 characters; text max 200 characters; optional figure (free text, max 20 characters); link to an internal page | exactly 3
- Director's word: quote max 600 characters; name max 100; function max 150; photo with alternative text | required
- Map of Algeria: base map image with alternative text (required, max 150 characters) | « Wilayas couvertes »: multi-select of the wilaya list, one marker per wilaya, placed from the wilaya's chef-lieu position | set in the « Carte + repères » block (FR-64)
- FAQ entry: question max 150 characters; answer max 1000 characters | 3–10 entries

**Rules & Constraints:**
- The section order above is fixed and cannot be changed by editors (FR-64).
- The hero title renders on at most 2 lines at viewport widths of 1024 px and above (UGP).
- The hero photograph changes every 6 seconds with a 1-second cross-fade; with reduced motion requested, only the first photograph is shown.
- The accompaniment steps advance every 8 seconds, pause on hover, on keyboard focus and with the pause button, and do not advance when reduced motion is requested.
- The map caption and its count of wilayas are generated from « Wilayas couvertes », so the count shown always matches the markers (the demo's homepage said 10 wilayas while Découvrir said 48). Markers are keyboard-focusable and their names are read by screen readers.
- Collections show published items only (projects, news, events).

**Edge Cases:**
- No published project → « Ils font l'ESS » is hidden.
- No upcoming event and no news → « Actu de l'ESS » is hidden; if only one of the two exists, only that one is shown.
- Hero photograph fails to load → plain deep-blue background; text contrast stays at least 4.5:1.
- No wilaya selected in « Wilayas couvertes » → the map is hidden and the figures take the full width.
- A block has no Arabic version → French text with the notice of FR-06.

---

#### FR-08 — Footer, Partner Logos and Accessibility Controls

**Description:** Every public page ends with the same footer: participation and newsletter highlights, sitemap links, partner logos, social links and accessibility controls; the footer also leads to a « Plan du site » page listing every public page.
*Source: demo footer (`js/layout.js`); UGP feedback V0, « Infos-Sommaire » and « Avec le soutien de »; v1.0 Q&A Q54, Q56, Q81.*

**Main Flow:**
1. Highlight band: "Participer" (text and "Passez à l'action" → FR-21 to FR-23) and "Newsletter" (FR-09).
2. Link columns: « Le portail », « Ressources », « À propos » (FAQ; the demo's « Le programme » and « Partenaires » links are removed), a utility list (Contact, Plan du site, Mentions légales, Confidentialité, Accessibilité — legal texts pending, Q18), and an identity block (logo, address, e-mail, copyright).
3. « Avec le soutien de »: the partner logos in the order Algérie, Union européenne, PNUD; under the European Union logo, the mention "Programme financé par l'Union européenne" (UGP; files and exact wording pending, Q15).
4. Utility bar: social-network links; « Accessibilité » group with "A", "A+", "A++" and "Contraste"; "Haut de page".
5. « Plan du site » opens a page listing every published public page, grouped by the sections of the main menu, in the current language.

**Data & Format:**
- Plan du site entry: page title + link | generated from the main menu and the published pages | not editable
- Taille du texte: enum | A (default), A+ (base text 18 px), A++ (base text 20 px) | remembered in the browser for 12 months
- Contraste: boolean | on / off | remembered in the browser for 12 months
- Social links: URL per network (Facebook, LinkedIn, X, YouTube) | https://… | set in the platform settings (FR-69c); optional

**Rules & Constraints:**
- The "Participer" block is hidden on the pages Participation, Contact, sign-in/registration, training registration and survey pages.
- Logos are displayed at the resolution supplied by the partners, never upscaled or recoloured, at least 48 px high on desktop and 40 px on mobile, with each partner's clear-space rule respected. They keep the same left-to-right order in the Arabic layout; they are not mirrored.
- Every footer link opens an existing page or section. A link without a target, including a social link without a URL, is not displayed.
- "Haut de page" scrolls to the top and moves keyboard focus to the skip link.
- « Plan du site » is generated, so a page that is unpublished (FR-64) leaves it automatically. The demo's `sitemap.html` (« Plan du site & écrans ») is an internal inventory of prototype screens and is not delivered.

**Edge Cases:**
- A partner logo file is missing → its alternative text is displayed in its slot and the order is kept.
- A page has no Arabic version → the Arabic « Plan du site » lists it under its French title, with the notice of FR-06.
- A++ on a 360 px screen → no horizontal scrolling on any page.
- Contrast mode → all text meets a contrast ratio of at least 7:1.
- Browser storage unavailable (private mode) → the controls work for the current page view only.

---

#### FR-09 — Newsletter Subscription

**Description:** A visitor can subscribe to the ESS newsletter with an e-mail address and explicit consent, confirm the subscription by e-mail, and unsubscribe at any time.
*Source: demo footer form « Newsletter »; Note de cadrage (abonnement e-mail + consentement); v1.0 Q&A Q45.*

**Main Flow:**
1. Visitor enters an e-mail address, ticks the consent box and clicks "S'abonner".
2. System validates and sends a confirmation e-mail, and displays "Merci ! Confirmez votre inscription depuis l'e-mail que nous venons de vous envoyer."
3. Visitor clicks the confirmation link; the subscription becomes active and a confirmation page is displayed.
4. Every e-mail sent to subscribers contains a one-click unsubscribe link.

**Data & Format:**
- E-mail: text | e-mail address | required, max 254 characters
- « J'accepte de recevoir des e-mails et la politique de confidentialité. »: checkbox | — | required
- Stored record: e-mail, language (fr / ar), consent date-time, confirmation date-time, status « En attente » / « Actif » / « Désabonné »

**Rules & Constraints:**
- A subscription is active only after confirmation. Unconfirmed subscriptions are deleted after 7 days.
- Administrators with the scope « Messagerie & annonces » can export active subscribers as CSV (e-mail, language, confirmation date) from the back-office; each export is recorded in the activity history (FR-56).
- Newsletters are composed and sent outside the platform; there is no archive of past newsletters.

**Edge Cases:**
- Address already active → the same success message; no duplicate is created and nothing reveals that the address is subscribed.
- Invalid address → "Veuillez saisir une adresse e-mail valide."
- Consent not ticked → "Veuillez accepter pour vous abonner." (the demo did not enforce this).
- A former subscriber subscribes again → a new confirmation is required.
- E-mail service unavailable → the request is queued and retried for 24 hours; the visitor sees the success message.

---

### Module 3 — Public Portal: Discover ESS

#### FR-10 — Discover ESS Page

**Description:** A visitor can learn what the ESS is, who its actors are, where to find support, its key figures, its legal framework, its link with public policies and the SDGs, and its place in the world.
*Source: demo `decouvrir.html`; UGP feedback V0, « Découvrir l'ESS », sections 1–7; v1.0 Q&A Q82.*

**Main Flow:**
1. Visitor opens "Découvrir l'ESS"; an in-page menu « Sur cette page » lists the sections and highlights the one in view.
2. Sections, in order:
   - **« Définition & principes »**: definition, 5 principles, « À retenir » box.
   - **« Typologie des acteurs »** (UGP typology), three categories as flip cards — front: name and icon; back: definition and examples:
     - Les entités (ou organisations) de l'ESS: associations, fondations, coopératives, mutuelles, entreprises sociales et groupes d'entraide respectant les principes de l'ESS;
     - Les initiatives ou projets à potentiel ESS: projets individuels encore en phase d'idéation ou de structuration, susceptibles d'évoluer vers une forme ESS;
     - Les bénéficiaires ou partenaires de l'écosystème ESS: artisans, agriculteurs, pêcheurs et entrepreneurs individuels pouvant être accompagnés par une organisation de l'ESS ou intégrés à une chaîne de valeur solidaire.
   - **« Où trouver un appui »** (UGP): main support actors grouped by category — le programme ESS; les antennes de l'ANGEM, de l'ADS et de NESDA; les incubateurs et CDE des universités; les incubateurs de la formation professionnelle; les incubateurs privés — each with a paragraph describing its contribution and a link "Voir les coordonnées" that opens the directory (FR-16) filtered on that category; paragraphs and structures pending (Q17).
   - **« Chiffres clés »**: FR-11.
   - **« Cadre légal »**: text naming associations, fondations, coopératives and mutuelles (UGP adds « fondations »), and a link to the legal texts in the resource centre (FR-24, type « Texte de loi »).
   - **« Politiques publiques & ODD »**: the paragraph supplied by the UGP and the link "Consulter la stratégie nationale de développement de l'ESS" (document pending, Q13).
   - **« L'ESS dans le monde »**: introduction text; a world map locating the countries where the ESS is strongly present, with connection arcs drawn from Algeria to them; the international figures with their source (e.g. "Source : OCDE (2024)").
   - **« Pour aller plus loin »**: "Découvrir des projets ESS" (→ FR-12), "Se faire accompagner" (→ FR-15), "Se former à l'ESS" (→ FR-18).
   - **Closing band**: "Vous portez un projet ESS ? Référencez votre projet, trouvez un financement, bénéficiez d'un accompagnement et rejoignez la communauté des acteurs de l'ESS." (UGP) with "Créer un compte" and "Voir les projets".
3. Visitor follows the links of interest.

**Data & Format:**
- Principle: title max 60 characters; text max 300 characters | exactly 5
- Typology card: name max 80 characters; definition max 400; examples max 300 | exactly 3
- Support category: name max 80 characters; paragraph max 600; linked directory category (FR-69a) | 1–8 categories
- Strategy document: URL (https://…) or PDF file max 20 MB | required for the link to show
- World figure: value; label max 80 characters; source max 120 characters; year (YYYY)
- World map: illustration (SVG) with alternative text, required, max 150 characters | replaceable through the « Carte + repères » block of the page (FR-64)

**Rules & Constraints:**
- The typology uses exactly the three UGP categories and their examples.
- Flip cards turn with click, tap, Enter or Space; the content of the back is readable by screen readers without flipping.
- The world map's arcs draw once when the map comes into view and then stay; they are decorative and hidden from screen readers, the map's alternative text carrying its meaning. With reduced motion requested, the arcs are shown already drawn.
- This page has no interactive map of structures (UGP; confirmation pending, Q17).

**Edge Cases:**
- Strategy document not yet supplied → the link is hidden; a broken link is never displayed.
- Reduced motion requested → both faces of each card are shown, stacked, without animation.
- A support category has no published directory entry → its "Voir les coordonnées" link is hidden.
- World map fails to load → its alternative text is shown and the international figures remain.
- Page opened with an anchor (e.g. #cadre-legal) → it scrolls to that section and the in-page menu highlights it.

---

#### FR-11 — Key Figures

**Description:** A visitor sees two sets of key figures — the ESS in Algeria and the results of the ESS programme — each with its source and reference date, identical wherever they appear.
*Source: demo homepage « L'ESS en chiffres » and `decouvrir.html` « Chiffres clés »; UGP feedback V0, « Bandeau 5 » and « Section 3 – Chiffres clés »; v1.0 Q&A Q78, Q83.*

**Main Flow:**
1. An administrator enters or updates the figures in the back-office (FR-64).
2. The homepage section « L'ESS en chiffres » and the « Chiffres clés » section of FR-10 display the two sets under the headings "L'ESS en Algérie" and "Le programme ESS".
3. On first view, each number counts up to its value, and numbers alternate between two brand colours (UGP).

**Data & Format:**
- Valeur: number | 0–999 999 999, Western digits, thousands separated by a space, optional suffix "+" or "%", decimal comma | required
- Libellé: text | FR and AR | required, max 80 characters
- Série: enum | "L'ESS en Algérie", "Le programme ESS" | required
- Source: text | free text | required, max 120 characters
- Date de référence: month and year | MM/YYYY | required
- Ordre d'affichage: integer | 1–6 | required

**Rules & Constraints:**
- Each figure is stored once and reused on every page; two pages can never show different values for the same figure (the demo showed both "1 254" and "1 250+"). The figures typed on the « Nos objectifs » cards (FR-07) are free text and outside this rule.
- A set holds 2 to 6 figures. The source and date are shown under each set: "Source : …, mise à jour MM/AAAA".
- Figures are entered by administrators; they are not computed from platform data, because programme results come from the programme's monitoring.
- With reduced motion requested, numbers appear at their final value without counting.

**Edge Cases:**
- A set has fewer than 2 figures → that set is hidden.
- Figures not supplied by launch (Q11, Q12) → the section is hidden; placeholder numbers are never published.
- Value with decimals (e.g. 10,4 %) → shown with a decimal comma and Western digits in both languages.
- Figure updated → every page shows the new value at its next load.

---

### Module 4 — Public Portal: Projects

#### FR-12 — Project Catalogue and Filters

**Description:** A visitor can browse published ESS projects and narrow them by keyword, sector, wilaya, legal form and stage of progress.
*Source: demo `projets.html`; UGP feedback V0, « Projets », sections 1–2; v1.0 Q&A Q30, Q84.*

**Main Flow:**
1. Visitor opens "Projets" and sees the counter "N projet(s) trouvé(s)" and project cards, 12 per page.
2. Visitor types a keyword and/or chooses Secteur, Wilaya, Forme juridique and a « Stade d'avancement » chip; results update within 1 second without reloading, and the URL reflects the filters so the view can be shared.
3. Visitor clicks a card or "Voir le projet" to open the project page (FR-13); "Tout effacer" resets every filter.

**Data & Format:**
- Recherche: text | free text, matched on title, summary, sector and wilaya, ignoring case and accents | optional, 2–100 characters
- Secteur: select | "Tous les secteurs" + sector list + "Autre" | default "Tous les secteurs"
- Wilaya: select | "Toutes les wilayas" + wilaya list sorted A–Z | default "Toutes les wilayas"
- Forme juridique: select | "Toutes les formes" + legal-form list (including « Groupe d'entraide » and « Projet sans statut juridique ») + "Autre" | default "Toutes les formes"
- Stade d'avancement: chips | "Tous", "Idéation", "Conception", "Financement", "Développement" (Q1) | single choice, default "Tous"
- Card (displayed): visual with alternative text; "Besoin : " followed by the project's needs; sector; wilaya; title; link "Voir le projet"

**Rules & Constraints:**
- Only projects with public status « Publié » (FR-60) are listed.
- Filters combine with AND. Each option list uses the same reference values as the project records, so every option can match (in the demo, three legal forms could never match).
- Projects entered with « Autre (préciser) » as sector or legal form are found under the option "Autre".
- Order: most recently published first.
- At widths of 768 px and below, a "Filtres" button opens a panel with a badge counting active filters and a button "Voir les résultats (N)".

**Edge Cases:**
- No result → "Aucun projet ne correspond" / "Essayez d'élargir vos critères ou réinitialisez les filtres." with "Tout effacer".
- Project without a visual → a default illustration for its sector; a broken image is never displayed.
- Invalid filter value in the URL → that filter is ignored and reset to its default.
- Keyword of 1 character → no filtering until a second character is typed.

---

#### FR-13 — Public Project Page

**Description:** A visitor can read the full public presentation of a published project and, once signed in, act on it according to their role.
*Source: demo `pages/projet.html`; UGP feedback V0, « Projets — Section 2 »; v1.0 Q&A Q85, Q124, Q135.*

**Main Flow:**
1. Visitor opens a project from the catalogue, the homepage, a search result or a structure page.
2. The page shows the header (sector, period, title, summary, visual, video if provided), the sections « Problématique », « Solution », « Bénéficiaires », « Rôle de l'ESS », « Impacts », « Partenaires & appui », the panel « En bref » (Secteur, Wilaya, Zone d'intervention, Forme juridique, Stade, Budget, Besoin) and « Projets similaires ».
3. Visitor clicks "Contacter le porteur":
   - signed out → sign-in or registration, then return to the project;
   - signed-in Citizen → contribution offer form (FR-43);
   - signed-in accredited Accompagnateur → the project in the accompagnateur space with "Proposer un accompagnement" (FR-39).

**Data & Format (from the project record, FR-32 and FR-60):**
- Title: text | max 100 characters
- Summary: text | max 300 characters
- Problématique, Solution: text | max 2000 characters each
- Bénéficiaires, Rôle de l'ESS, Impacts, Partenaires & appui: text | max 1000 characters each
- Période: text | "AAAA – AAAA" | optional
- Budget: number | integer in DZD, displayed "6 200 000 DA" | optional
- Video: URL | YouTube or Vimeo | optional

**Rules & Constraints:**
- A section without content is hidden. Template text is never generated (the demo filled « Problématique » and « Impacts » from per-sector templates).
- Never displayed: team e-mails, dossier documents, refusal reasons, applications, contributions.
- The texts are shown in the language they were written in (FR-32); when it differs from the interface language, the notice « Projet présenté en français » or « Projet présenté en arabe » is shown.
- « Projets similaires » shows up to 3 published projects of the same sector, completed with the most recently published projects if fewer exist.
- "Contacter le porteur" is not shown to Entrepreneurs, Trainers and administrators; an Entrepreneur viewing their own project sees "Voir dans mon espace" instead. It is not shown on showcase projects (FR-60).

**Edge Cases:**
- Unknown or unpublished project → page "Projet introuvable" (HTTP 404) with a link to the catalogue (the demo showed the first project instead).
- Video unreachable → the video block is replaced by "La vidéo n'est pas disponible pour le moment."
- Accompagnateur without accreditation → the button is replaced by "Votre agrément est requis pour proposer un accompagnement."
- Project unpublished while a visitor is on the page → the next load shows the 404 page.

---

#### FR-14 — Featured Projects (« Ils font l'ESS »)

**Description:** The homepage shows a rotating selection of published projects chosen by administrators as « Projets du mois ».
*Source: demo homepage section « Ils font l'ESS »; UGP feedback V0, « Bandeau 6 » (selection question; scrolling band or « projets du mois » suggested); v1.0 Q&A Q3.*

**Main Flow:**
1. An administrator marks published projects « À l'affiche » and sets the month in which each is shown (FR-60).
2. The homepage section « Ils font l'ESS » displays them under the label « Projets du mois » as a carousel: 3 cards visible at 1024 px and above, 2 on tablet, 1 on mobile with swipe; previous / next buttons and a position indicator.
3. Visitor opens a card (→ FR-13) or "Tous les projets" (→ FR-12).

**Data & Format:**
- À l'affiche: boolean | per project | default false
- Mois d'affichage: month | MM/YYYY | optional; without a month the project stays featured until it is unmarked
- Ordre: integer | 1–12 | set by drag and drop in the back-office
- Card (displayed): same fields as the catalogue card (FR-12)

**Rules & Constraints:**
- At most 12 projects are featured at the same time, displayed in the order set by administrators.
- A project whose display month is not the current month is not shown; its flag is kept.
- If fewer than 3 featured projects are active, the carousel is completed with the most recently published projects.
- The carousel advances every 6 seconds with a visible pause button, stops on hover and keyboard focus, and does not advance when reduced motion is requested.

**Edge Cases:**
- No published project at all → the section is hidden.
- A featured project is unpublished → it leaves the carousel at the next page load.
- Only 1 or 2 projects to show → they are displayed without carousel controls.
- A 13th project marked « À l'affiche » → "12 projets au maximum peuvent être à l'affiche. Retirez-en un d'abord."

---

### Module 5 — Public Portal: Accompaniment & Financing

#### FR-15 — Accompaniment and Financing Page

**Description:** A visitor can understand the accompaniment journey, get oriented according to their need, and reach the structures and financing sources relevant to them.
*Source: demo `accompagnement.html`; UGP feedback V0, « Accompagnement », bandeaux 1–6; v1.0 Q&A Q29.*

**Main Flow:**
1. **Bandeau 1 « Accompagnement et financement »**: introduction paragraph (kept as is, UGP).
2. **Bandeau 2 « Un parcours adapté à votre besoin »** (former bandeau 4, title proposed by the UGP): the 4 phases Pré-incubation, Incubation, Accélération, Financement with what each brings, and the note that private spaces require registration and validation.
3. **Bandeau 3 « Que cherchez-vous ? Laissez-vous orienter »** (former bandeau 6, UGP): 4 cards — "Découvrir l'ESS et trouver une idée" (→ pré-incubation), "Préparer et lancer un projet" (→ incubation), "Développer un projet existant" (→ accélération), "Chercher un financement" (→ bandeau 5).
4. **Bandeau 4 « Qui fait quoi ? Les acteurs de l'accompagnement »**: directory of FR-16.
5. **Bandeau 5 « Se faire financer — Panorama des sources de financement »**: FR-17.
6. When the visitor clicks one of the first three orientation cards: signed out → registration with the Entrepreneur profile preselected and the phase remembered; signed-in Entrepreneur → project wizard (FR-32) with "Accompagnement recherché" preset to that phase.

**Data & Format:**
- Phase preset: enum | preincubation, incubation, acceleration | carried as a URL parameter; indicative only

**Rules & Constraints:**
- The three capsules « Acteurs & dispositifs / Se faire accompagner / Se faire financer » are not displayed (UGP: duplicate of the content below).
- The bandeau order above is fixed.
- The phase preset is a wish; the administrator decides the phase at orientation (FR-57).

**Edge Cases:**
- Signed-in Citizen, Trainer or Accompagnateur clicks an orientation card → message "Cette orientation est destinée aux porteur·se·s de projet." and no redirection.
- Invalid phase parameter → ignored; "Accompagnement recherché" stays at "Je ne sais pas encore".
- Visitor arriving from a card registers with another profile → the preset is discarded.

---

#### FR-16 — Support-Structure Directory and Structure Page

**Description:** A visitor can browse accompaniment structures by category and open each structure's page with its services and contact details.
*Source: demo `accompagnement.html` (« Les acteurs de l'accompagnement »), `pages/acteur.html`; UGP feedback V0, « Bandeau 3 – Qui fait quoi ? » and « Découvrir l'ESS — Section 2 » (contact details in the accompaniment space); v1.0 Q&A Q64, Q82.*

**Main Flow:**
1. In bandeau 4 the visitor sees two groups — "Structures d'accompagnement" and "Acteurs de financement", the latter linking to bandeau 5 — and the category chips "Tous", "Institutions ou dispositifs", "Pré-incubateurs", "Incubateurs", "Accélérateurs", "Réseaux ESS", each with its count.
2. Visitor filters by chip and/or keyword — or arrives from « Où trouver un appui » (FR-10) with the matching support category applied as a removable filter — and sees rows: name, category, zone, thematic, description, "Voir la structure".
3. The structure page shows « La structure » (description, year established, number of projects accompanied), « Services proposés », « Coordonnées » (address, phone, e-mail, website), « Projets accompagnés », « Accompagnateur·rice·s de la structure » (accredited accompagnateurs linked to it, FR-36), the panel « En bref » (Type, Zone d'action, Thématique, Depuis, Projets accompagnés) and « Autres structures » (4 of the same category).

**Data & Format:**
- Recherche: text | free text, matched on name, zone, thematic and description, ignoring case and accents | optional, 2–100 characters
- Catégorie: chips | the 5 categories above | single choice, default "Tous"
- Catégorie « Où trouver un appui »: URL parameter | the support categories of FR-10 | optional, shown as a removable filter
- Structure fields: as defined in FR-69a

**Rules & Constraints:**
- « Institutions ou dispositifs » covers ANGEM, NESDA, ADS, ANEM, the sectoral directorates of the wilayas and the professional chambers (UGP typology).
- Only published structures are listed, sorted A–Z. A keyword equal to a wilaya also matches structures whose zone is "National".
- A chip with 0 structures is displayed disabled.
- "Contacter" opens the structure's e-mail or website; it is hidden when neither is provided.

**Edge Cases:**
- Unknown or unpublished structure → page "Structure introuvable" (HTTP 404).
- Structure without contact details → « Coordonnées » is hidden.
- No match → "Aucune structure ne correspond."
- No published project linked → the list « Projets accompagnés » is hidden; the declared number is still shown in « En bref ».

---

#### FR-17 — Financing-Sources Panorama

**Description:** A visitor can explore financing sources classified by the UGP's seven-category typology and by project phase.
*Source: demo `accompagnement.html` (« Panorama des dispositifs de financement »); UGP feedback V0, « Bandeau 5 » (« sources de financement », typology A–G); v1.0 Q&A Q28, Q86.*

**Main Flow:**
1. Visitor sees bandeau 5 with category chips A to G and phase chips "Toutes les phases", "Création / lancement", "Développement".
2. Visitor filters and sees rows: organisation — scheme, category, sub-category, phase, target public, description, "En savoir plus" and "Être accompagné vers ce financement".
3. "Être accompagné vers ce financement": signed out → registration with the Entrepreneur profile and phase Financement preset; signed-in Entrepreneur → project wizard with Financement preset.

**Data & Format:**
- Catégorie / sous-catégorie: enum | A Financement public (Fonds publics; Collectivités locales; Agences d'appui — ANGEM, NESDA, ADS…) · B Financement bancaire et financier (Banques et établissements financiers; Fonds de garantie) · C Coopération internationale (Bailleurs bilatéraux; Bailleurs multilatéraux; Organisations internationales) · D Finance solidaire et inclusive (Mutuelles; Fonds Zakat et Waqfs; Mécanismes communautaires) · E Investissement à impact et secteur privé (Fondations; Entreprises; Investisseurs à impact) · F Financement citoyen (Crowdfunding; Dons) · G Ressources propres (Revenus d'activité; Cotisations; Réinvestissement des excédents) | required
- Phase: enum | "Création / lancement", "Développement", "Les deux" | required
- Other fields: as defined in FR-69a

**Rules & Constraints:**
- The section title uses « sources de financement », not « dispositifs » (UGP).
- Category G describes self-financing levers, not organisations: its rows show a description only, without "Être accompagné vers ce financement".
- Only published sources are listed, ordered by category, then by name.
- Category F entries are informative; the platform collects no money.

**Edge Cases:**
- Category without entries → its chip is disabled.
- No official link → "En savoir plus" is hidden.
- No result → "Aucune source de financement ne correspond."

---

### Module 6 — Public Portal: Academy

#### FR-18 — Training Catalogue and Filters

**Description:** A visitor can browse published trainings and filter them by keyword, format, level and audience.
*Source: demo `academie.html`; UGP feedback V0, « Académie — Formation : RAS »; v1.0 Q&A Q9, Q87, Q108.*

**Main Flow:**
1. Visitor opens "Académie" and sees the counter "N formation(s)" and training cards, 12 per page.
2. Visitor filters by keyword, Format, Niveau and Public; "Tout effacer" resets.
3. Each card shows format, level, audience, duration, title (→ FR-19), the next session's date and places left or "Complet", and "S'inscrire" (→ FR-20) or "Liste d'attente" (→ FR-44a).

**Data & Format:**
- Recherche: text | matched on title, thematic and summary, ignoring case and accents | optional, 2–100 characters
- Format: select | "Tous les formats", "En ligne", "Présentiel", "Hybride" | default all
- Niveau: select | "Tous les niveaux", "Débutant", "Intermédiaire", "Avancé" | default all
- Public: select | "Tous les publics", "Apprenant", "Porteur de projet", "Formateur" | default all

**Rules & Constraints:**
- The catalogue lists every training with status « Publiée », including trainings authored by Trainers (FR-48, FR-61) and by administrators (FR-61a); the demo listed only fixed demo data.
- Order: in-person and hybrid sessions by session date (soonest first), then online trainings by publication date (newest first).
- An in-person or hybrid training is listed only while it has at least one upcoming session (FR-48a).
- When the next session's places left reach 0, the card shows "Complet" and offers its waiting list (FR-44a).

**Edge Cases:**
- No result → "Aucune formation ne correspond".
- Training withdrawn (FR-61) → it disappears at the next load; its direct link returns a 404 page.
- Training without a thumbnail → default illustration of its thematic.

---

#### FR-19 — Training Page

**Description:** A visitor can read a training's objectives, prerequisites, programme, format, trainer and session details.
*Source: demo `pages/formation.html`; v1.0 Q&A Q87.*

**Main Flow:**
1. Visitor opens a training from the catalogue, a search result or another training page.
2. The page shows title, thematic, trainer (name, title, photo), « Objectifs pédagogiques », « Prérequis », « Programme », « Public & format », and the panel « La formation en bref » (Format, Niveau, Durée, Public, Tarif); in-person and hybrid trainings add their upcoming sessions, each with date, time, place and places left.
3. Visitor clicks "S'inscrire" on a session (→ FR-20), or "Rejoindre la liste d'attente" on a full one (→ FR-44a), or opens one of the 3 trainings of « Autres formations ».

**Data & Format (from the training record, FR-48):**
- Objectifs pédagogiques: list | 1–8 items, max 200 characters each
- Prérequis: text | max 500 characters | optional
- Programme: list | 1–20 lines, max 200 characters each
- Tarif: text | "Gratuit" (all trainings are free)

**Rules & Constraints:**
- An online training shows "Accessible avec un compte"; its content and quiz are available in the learning space only (FR-44).
- A session whose start date-time has passed shows "Session terminée" and no registration button.
- « Autres formations » shows up to 3 published trainings of the same thematic, completed with the most recent ones.

**Edge Cases:**
- Unknown or unpublished training → 404 page "Formation introuvable".
- No prerequisite → "Aucun prérequis".
- Trainer account suspended → the trainer block shows the name only.

---

#### FR-20 — Training Registration

**Description:** A person can register for a training session; in-person and hybrid sessions accept registration without an account, online trainings require one.
*Source: demo `pages/inscription.html` (« Inscription possible sans créer de compte »), `intranet/formation.html` (registration modal); guest registration pending the client's confirmation (Q5); v1.0 Q&A Q88, Q127, Q133.*

**Main Flow:**
1. Person clicks "S'inscrire" on a card or a training page.
2. Online training: a signed-out person is sent to sign-in or registration, then to the learning space; a signed-in person opens the registration of FR-44.
3. In-person or hybrid training, signed out: form « S'inscrire à une formation » with the training preselected and the panel « Votre formation » (title, format, level, duration, price).
4. System checks the places left, records the registration, decreases the places left, and sends a confirmation e-mail with date, time and place, or the joining link for remote participation; the page shows the confirmation.

**Data & Format:**
- Formation: select | published trainings with an open session | required, preselected
- Séance: select | the upcoming sessions of the chosen training | required, preselected when chosen on the training page
- Nom complet: text | free text | required, 2–100 characters
- E-mail: text | e-mail address | required, max 254 characters
- Téléphone: text | 0XXXXXXXXX or +213XXXXXXXXX | required
- Wilaya: select | wilaya list | optional
- Vous êtes: select | "Apprenant", "Porteur de projet", "Formateur", "Autre" | required
- Comment souhaitez-vous participer ? (hybrid only): radio | "Sur place", "En direct" | required
- Motivation (optionnel): text | free text | optional, max 500 characters
- « J'accepte d'être recontacté(e) au sujet de cette inscription. »: checkbox | — | required

**Rules & Constraints:**
- One registration per e-mail address per session.
- Capacity applies to on-site places; "En direct" participation of a hybrid session is not limited.
- Registration closes at the session's start date-time.
- A registration made without an account is attached to the account with the same e-mail address, existing or created later, once that account's e-mail address is verified.
- The last place is allocated atomically and shared with registrations made from the learning space (FR-44): of two simultaneous requests, the second receives "Cette session est complète." and is offered the waiting list (FR-44a).
- The confirmation e-mail contains "Annuler mon inscription", valid until the session starts; cancelling frees the place.

**Edge Cases:**
- Session becomes full while the form is open → on submit "Cette session est complète." and links to the other sessions and to the waiting list.
- E-mail already registered for the session → "Vous êtes déjà inscrit·e à cette session."; no duplicate is created.
- Invalid phone number → "Numéro de téléphone invalide (ex. 0550 12 34 56)."
- Training withdrawn after registration → registrants are informed by e-mail (FR-61).

---

### Module 7 — Public Portal: Citizen Participation

#### FR-21 — Surveys and Consultations

**Description:** Visitors and members can see surveys and consultations, answer the open ones, and read published results.
*Source: demo `participation.html` (tab « Sondages »), `pages/sondage.html`; UGP feedback V0, « S'engager – Participation » (3 parts; « Sondage : RAS »); v1.0 Q&A Q43, Q44, Q128.*

**Main Flow:**
1. Visitor opens "Participation", part « Participer à un sondage »: cards with status tag (« Ouvert », « Résultats disponibles », « Clôturé », « À venir »), thematic, title, date label ("Clôture le", "Publié le", "Clôturé le", "Ouverture le") and action ("Répondre", "Voir les résultats", "Bientôt" disabled, "Clôturé" disabled).
2. "Répondre" opens the questionnaire one question at a time: "Question X / N", progress bar, "Précédent" / "Suivant".
3. On the last step, the respondent ticks the consent box and clicks "Envoyer mes réponses".
4. System records the response and displays a thank-you message; when results are published, "Voir les résultats" shows them.

**Data & Format:**
- Choice answer: radio | one of 2–10 options | required
- Scale answer: radio | integer 1 to N, N ∈ {3, 4, 5, 7, 10} | required
- Text answer: text | free text, prompt "Partagez votre avis…" | optional, max 1000 characters
- Consent: checkbox | anonymous survey: "J'accepte que ma réponse soit utilisée de façon anonyme."; nominative survey: consent notice naming the data collected | required

**Rules & Constraints:**
- Nominative surveys require sign-in (any role); anonymous surveys are open to visitors.
- One response per account for nominative surveys; one response per browser for anonymous surveys.
- Responses are accepted only while the survey is « Ouvert »; it closes automatically at its closing date-time or when its response quota is reached (FR-67). The quota is counted atomically: a response beyond it is refused with "Ce sondage est clôturé, votre réponse n'a pas pu être enregistrée."
- "Envoyer mes réponses" stays disabled until every choice and scale question is answered, with the message "Encore N question(s) avant de pouvoir envoyer."
- Published results show, per question: choice → percentage bars sorted in descending order with the number of responses; scale → distribution and mean to one decimal. Text answers are never shown publicly. A rate that cannot be computed is shown as « — ».

**Edge Cases:**
- Survey closes while the respondent is answering → on submit "Ce sondage est clôturé, votre réponse n'a pas pu être enregistrée."
- Respondent has already answered → "Vous avez déjà répondu à ce sondage." with "Voir les résultats" when published.
- Respondent leaves mid-questionnaire → answers are kept in the browser for 24 hours and restored on return.
- "Suivant" without an answer → "Veuillez sélectionner une réponse pour continuer."

---

#### FR-22 — Volunteering

**Description:** A visitor can discover projects seeking volunteers and, once signed in as a Citizen, offer to help.
*Source: UGP feedback V0, « Participation — Partie « travail bénévole » : à rajouter »; demo citizen contribution « Bénévolat » (`intranet/cit-projet.html`) and project need « Bénévoles »; v1.0 Q&A Q6, Q124.*

**Main Flow:**
1. In "Participation", part « Travail bénévole » explains volunteering and lists published projects — showcase projects excepted (FR-60) — whose needs include « Bénévoles »: visual, title, sector, wilaya, "Proposer mon aide".
2. Visitor clicks "Proposer mon aide": signed out → sign-in or registration as Citizen, then return; signed-in Citizen → contribution form of FR-43 with type « Bénévolat » preselected.
3. Once sent, the offer appears in the Citizen's « Mes contributions » with status « En attente ».

**Data & Format:**
- Secteur: select | "Tous les secteurs" + sector list | default all
- Wilaya: select | "Toutes les wilayas" + wilaya list | default all
- Card (displayed): as in the catalogue (FR-12)

**Rules & Constraints:**
- Only Citizen accounts can offer volunteering.
- A project whose needs no longer include « Bénévoles » leaves the list; offers already made are not affected.
- 6 projects per page, most recently published first.

**Edge Cases:**
- No project seeking volunteers → "Aucun projet ne recherche de bénévoles pour le moment." with an invitation to subscribe to the newsletter.
- Signed-in user with another role → "Le bénévolat se propose depuis un compte citoyen·ne."
- Citizen already has a pending volunteering offer on the project → the button reads "Offre envoyée" and is disabled.

---

#### FR-23 — Mentoring

**Description:** A visitor can discover projects seeking a mentor and, once signed in as a Citizen, offer mentoring.
*Source: UGP feedback V0, « Participation — Partie « mentorat » : à rajouter »; demo project need « Mentorat »; mentor vetting pending (Q3); v1.0 Q&A Q124.*

**Main Flow:**
1. In "Participation", part « Mentorat » explains what mentoring involves and lists published projects — showcase projects excepted (FR-60) — whose needs include « Mentorat »: visual, title, sector, wilaya, "Proposer du mentorat".
2. Visitor clicks "Proposer du mentorat": signed out → sign-in or registration as Citizen, then return; signed-in Citizen → contribution form of FR-43 with type « Mentorat » preselected.
3. Once sent, the offer appears in « Mes contributions » with status « En attente ».

**Data & Format:**
- Secteur: select | "Tous les secteurs" + sector list | default all
- Wilaya: select | "Toutes les wilayas" + wilaya list | default all
- Mentoring offer fields: as defined in FR-43

**Rules & Constraints:**
- Only Citizen accounts can offer mentoring.
- Mentors are not vetted by administrators before offering; the Entrepreneur decides (FR-43). Whether prior vetting is required is pending (Q3).
- 6 projects per page, most recently published first.

**Edge Cases:**
- No project seeking a mentor → "Aucun projet ne recherche de mentor pour le moment."
- Signed-in user with another role → "Le mentorat se propose depuis un compte citoyen·ne."
- Citizen already has a pending mentoring offer on the project → "Offre envoyée", disabled.

---

### Module 8 — Public Portal: Resources, News & Media

#### FR-24 — Resource Centre

**Description:** A visitor can find and download ESS documents filtered by content type, thematic, language and format.
*Source: demo `ressources.html` (tab « Supports »); UGP feedback V0, « Ressources : RAS »; v1.0 Q&A Q90.*

**Main Flow:**
1. Visitor opens "Ressources", tab "Supports (N)".
2. Visitor ticks filters and chooses a sort order; the counter "N résultat(s)" and the list update.
3. Each row shows a cover by type, category, title, description, year, language, format and size, and "Télécharger".
4. Visitor clicks "Télécharger"; the file downloads.

**Data & Format:**
- Type de contenu: checkboxes | "Guide", "Texte de loi", "Étude", "Boîte à outils" | multiple
- Thème: checkboxes | sector list | multiple
- Langue: checkboxes | "FR", "AR", "FR / AR" | multiple
- Format: checkboxes | "PDF", "DOCX", "XLSX" | multiple
- Trier par: select | "Plus récent" (default), "Plus ancien", "Titre A–Z"

**Rules & Constraints:**
- Options within one group combine with OR; groups combine with AND.
- The count beside each option reflects the other active filters (the demo showed fixed counts).
- "Tout effacer" resets filters and sort. 8 results per page.
- "Télécharger" serves the current version of the file (FR-66). A download counts once per visitor and resource per day; downloads by robots are not counted.
- Only published resources are listed.

**Edge Cases:**
- No result → "Aucune ressource ne correspond".
- File missing from storage → "Ce document est momentanément indisponible."; the error is logged.
- Arabic-only document in the French interface → listed with language tag "AR".

---

#### FR-25 — Webinar Replays

**Description:** A visitor can watch recordings of past webinars, freely and without registration.
*Source: demo `ressources.html` (tab « Replays »), `pages/replay.html`.*

**Main Flow:**
1. Visitor opens tab "Replays (N)" and filters by thematic chip ("Tous" + thematics present).
2. Visitor opens a replay; the page shows the player, « À propos de ce replay », « L'intervenant·e » and « La session en bref » (Thème, Intervenant·e, Date, Horaire, Durée, Format « Webinaire en ligne »).
3. Visitor plays the video, or follows "Poursuivre" to related resources.

**Data & Format:**
- Vidéo: YouTube or Vimeo URL, or uploaded MP4 file (max 500 MB)
- Durée: text | "X min" or "H h MM" | required
- Date / Horaire: date DD/MM/YYYY; time HH:MM | required

**Rules & Constraints:**
- Replays are free to watch: "Replay libre d'accès, sans inscription."
- 6 replays per page; only published replays are listed.
- A thematic chip is displayed only when at least one published replay has that thematic.

**Edge Cases:**
- Video not yet available → "La vidéo de cette session n'est pas encore en ligne…".
- Video provider blocked on the visitor's network → the message above and a link to open the video on the provider's site.
- Unknown or unpublished replay → 404 page.

---

#### FR-26 — « Actu de l'ESS »: News Feed and Article Page

**Description:** A visitor can follow ESS news and upcoming events in a single feed and read each article.
*Source: demo `medias.html` (« Fil d'actualité »), `pages/article.html`, homepage « Agenda » and « L'actualité de l'ESS »; UGP feedback V0, « Bandeau 8 » and « Bandeau 9 » (merge recommended), « Participation — Évènement », « Médias »; v1.0 Q&A Q5, Q91, Q119.*

**Main Flow:**
1. Visitor opens "Médias", tab « Fil d'actualité »: upcoming events (soonest first) pinned at the top, then news (newest first).
2. Visitor filters with type chips "Tout", "Actualités", "Événements" and scope chips "Algérie", "International".
3. A news card shows image, category, date, title, excerpt and "Lire"; an event card shows date, time, place, format and "Participer" (FR-27).
4. The article page shows category, scope, date, title, image with credit, body, share buttons (Facebook, LinkedIn, X, "Copier le lien") and « Articles liés » (3, same scope).

**Data & Format:**
- Fields of news and events: as defined in FR-65
- Feed paging: 9 items, then "Voir plus" loads 9 more

**Rules & Constraints:**
- The homepage section « Actu de l'ESS » (FR-07) shows the next 3 upcoming events and a carousel of the 8 latest news items.
- Only published items appear anywhere — feed, homepage, search, related articles (the demo showed drafts on the homepage and in search).
- An item scheduled for later appears at its publication date-time.
- Past events leave the feed but stay reachable by their link and through search. A cancelled event stays in the feed with the tag « Annulé » and no "Participer" button until its date (FR-65).
- Events are no longer listed in Participation (UGP); « Agenda » in the footer opens the feed filtered on "Événements".

**Edge Cases:**
- Empty feed → "Aucune actualité pour le moment."
- Article unpublished → 404 page.
- "Copier le lien" blocked by the browser → the link is shown in a selectable field.
- Article without an image → no image block.

---

#### FR-27 — Events and Event Registration

**Description:** A visitor can consult an event and register for it when registration is required.
*Source: demo `pages/evenement.html`, sign-up modal (`js/ui.js`, `[data-signup]`), `participation.html` (tab « Événements »); v1.0 Q&A Q92, Q119, Q127.*

**Main Flow:**
1. Visitor opens an event from the feed, the homepage or search; the page shows date, time, place, format, organiser, description, attachments, « Bon à savoir » and places left.
2. Visitor clicks "Participer" and completes the form.
3. System checks places, records the registration and shows "Participation enregistrée — Merci ! Un e-mail de confirmation vient de vous être envoyé, avec le lieu, l'horaire et les détails pratiques."
4. System e-mails the confirmation, with the joining link for online events and the link "Annuler ma participation", valid until the event starts.

**Data & Format:**
- Nom et prénom: text | free text | required, 2–100 characters
- E-mail: text | e-mail address | required, max 254 characters
- Organisation (facultatif): text | free text | optional, max 150 characters

**Rules & Constraints:**
- "Participer" appears only when the event requires registration (FR-65).
- One registration per e-mail address per event.
- When places left reach 0, the button reads "Complet" and is disabled; events without a capacity are not limited.
- Registration closes at the event's start date-time; past events show "Inscriptions closes".
- If an event is cancelled or its date, time or place changes, registrants are informed by e-mail. A cancelled event stays visible with the tag « Annulé » and no "Participer" button until its date.
- The last place is allocated atomically; cancelling a participation frees the place.

**Edge Cases:**
- Event becomes full while the form is open → "Cet événement est complet."
- E-mail already registered → "Vous êtes déjà inscrit·e à cet événement."
- Unknown or unpublished event → 404 page.
- Empty name or invalid e-mail → "Veuillez indiquer votre nom." / "Veuillez saisir une adresse e-mail valide."

---

#### FR-28 — Media Library

**Description:** A visitor can browse photo albums and videos of the programme and open any photo or album in an enlarged view.
*Source: demo `medias.html` (« L'ESS en images »); UGP feedback V0, « Médias — Fil d'actualité - Médiathèque - L'ESS en Image : si possible, élargir la photo/album en cliquant dessus ».*

**Main Flow:**
1. Visitor opens "Médias", tab « Médiathèque » (albums and videos) or « L'ESS en images » (photo mosaic).
2. Visitor clicks a photo or an album cover; an enlarged viewer opens with the photo, its caption and credit, previous / next controls and a counter "3 / 24".
3. Visitor navigates with the arrows, keyboard arrows or swipe, and closes with "×", Esc or a click outside the photo.

**Data & Format:**
- Album and photo fields: as defined in FR-68

**Rules & Constraints:**
- Each photo displays its credit (mandatory, FR-68).
- While the viewer is open, keyboard focus stays inside it, and returns to the clicked photo on close.
- The viewer loads the selected photo first, then the next one in advance.

**Edge Cases:**
- A photo fails to load → "Image indisponible" in the viewer; navigation continues.
- Album with one photo → no previous / next controls.
- Reduced motion requested → no zoom animation on opening.

---

#### FR-29 — Site Search

**Description:** A visitor can search all published content of the portal from one field and open any result.
*Source: demo `recherche.html`; v1.0 Q&A Q93, Q135.*

**Main Flow:**
1. Visitor types in the search field of the search page (or arrives from the header with ?q=).
2. Results update 300 ms after the last keystroke, or on "Rechercher"; the counter "N résultat(s)" is shown.
3. Visitor narrows by type chips: "Tout", "Projets", "Actualités", "Événements", "Formations", "Ressources", "Replays", "Structures", "Financements", "Sondages".
4. Visitor opens a result: type tag, title, excerpt with the term highlighted, link to the item's own page.

**Data & Format:**
- Requête: text | free text | 2–100 characters; longer input is cut at 100 characters

**Rules & Constraints:**
- Search ignores case and accents and covers the content of the current language; in Arabic it also covers the French version of content that has no Arabic version. Projects are found from both interfaces, whatever their writing language (FR-32).
- Only published items are returned.
- Each result opens the item's own page (the demo sent trainings and resources to their list pages).
- Results are ordered by relevance (title match before body match), then by date, newest first.

**Edge Cases:**
- No result → "Aucun résultat" / "Essayez d'autres mots-clés…".
- Query of 1 character → "Saisissez au moins 2 caractères."
- Special characters in the query → treated as plain text.

---

#### FR-30 — Contact Form

**Description:** A visitor can send a message to the platform team and receives an acknowledgement.
*Source: demo `contact.html`; v1.0 Q&A Q46.*

**Main Flow:**
1. Visitor opens "Contact": form, « Coordonnées » (address, e-mail, phone, map) and a short FAQ.
2. Visitor completes the form, ticks consent and clicks "Envoyer".
3. System checks the input and the anti-spam control, sends the message to the configured mailbox, e-mails an acknowledgement to the visitor and displays a confirmation.

**Data & Format:**
- Nom: text | free text | required, 2–100 characters
- Adresse électronique: text | e-mail address | required, max 254 characters
- Objet: text | free text | required, max 150 characters
- Message: text | free text | required, 10–3000 characters
- « J'accepte que mes informations soient utilisées pour traiter ma demande. »: checkbox | — | required

**Rules & Constraints:**
- An anti-spam control that requires no puzzle from legitimate users protects the form; at most 5 messages per e-mail address per hour are accepted.
- Each message is e-mailed to the mailbox set in the platform settings (FR-69c) — address pending (Q19) — and stored in the contact inbox (FR-52a).
- Messages are kept 12 months, then deleted (pending validation, Q20).

**Edge Cases:**
- Message under 10 characters → "Votre message doit contenir au moins 10 caractères."
- Anti-spam check fails → "Votre message n'a pas pu être envoyé. Réessayez."
- E-mail service unavailable → the message is queued and retried for 24 hours; the visitor sees the confirmation.
- Required fields missing → "Merci de corriger les champs en rouge."

---

### Module 9 — Entrepreneur Space: Projects

#### FR-31 — Entrepreneur Dashboard and To-do List

**Description:** An Entrepreneur sees at a glance the state of their projects and the actions waiting for them.
*Source: demo `intranet/index.html` (`js/intra-dashboard.js`); v1.0 Q&A Q94, Q95, Q121.*

**Main Flow:**
1. Entrepreneur signs in and lands on the dashboard: "Bonjour {prénom}" and the button "Nouveau projet" (→ FR-32).
2. Indicator tiles: "Projets actifs", "Demandes en cours", "Actions à faire", "Formations suivies".
3. The « À faire » list shows tasks requiring an action first, then information items; each task has its action button.
4. The side column shows « Mes projets » (3 most recent) and « Formations & ressources ».

**Data & Format:**
- Task types (label → button):
  - "Proposition d'accompagnement reçue" → "Répondre"
  - "Proposition de bénévolat reçue" / "Proposition de mentorat reçue" / "Promesse de don reçue" → "Répondre"
  - "Demande d'accompagnement acceptée" → "Contacter"
  - "Finaliser votre brouillon" → "Reprendre"
  - "Compléter votre dossier (N documents)" → "Continuer"
  - "Choisir un·e accompagnateur·rice" → "Choisir"
  - "Projet à revoir" (with the reason) → "Revoir"
  - "Compléments demandés sur votre dossier" → "Corriger"
  - "Nouvelle phase ouverte" → "Voir les documents"
  - Information only: "Sélection en cours", "Projet en cours d'examen", "Dossier en validation", "Demande d'accompagnement en attente"
- "Projets actifs": count of the Entrepreneur's projects not « Brouillon », « Refusé », « Retiré » or « Terminé »
- "Demandes en cours": count of the Entrepreneur's applications with status « soumise »

**Rules & Constraints:**
- Every count and task concerns only projects the user owns or is a team member of. (The demo had no ownership: every seeded project belonged to every user.)
- A task disappears as soon as its action is done.
- Order: action tasks, newest first, then information items, newest first.

**Edge Cases:**
- No task → "Rien à faire pour le moment. Bon travail !"
- No project → « Mes projets » shows "Vous n'avez pas encore de projet." with "Soumettre un projet".
- E-mail not verified → the verification banner of FR-01 is displayed above the tiles.
- Team member without owner rights → tasks reserved to the owner are shown as information only.

---

#### FR-32 — Project Submission Wizard

**Description:** An Entrepreneur can describe a project in four short steps, save it as a draft at any time, and submit it for review.
*Source: demo `intranet/mon-projet.html?new=1` (`js/intra-projet.js`); FR-15 (phase preset); v1.0 Q&A Q4, Q31, Q35, Q84, Q125, Q135.*

**Main Flow:**
1. Entrepreneur clicks "Nouveau projet" or "Soumettre un projet"; the wizard « Créer votre projet » opens at "Étape 1 sur 4 · Environ 5 min".
2. Step 1 « Identité », step 2 « Votre projet », step 3 « Impact », step 4 « Besoins » with a recap of all answers.
3. "Continuer" validates the current step and saves the draft; "Précédent" goes back; "Enregistrer et quitter" saves the project as « Brouillon » and returns to « Mes projets ».
4. On step 4, "Soumettre le projet" sets the status to « Soumis » (shown "En examen"), adds the project to the administrators' queue (FR-70), notifies administrators and displays a confirmation.

**Data & Format:**
- Nom du projet: text | free text | required, 3–100 characters
- Type de structure: select | legal-form list + "Autre (préciser)" with a text field of max 60 characters | required
- Secteur: select | sector list + "Autre (préciser)" with a text field of max 60 characters | required
- Wilaya: select | wilaya list | required
- Photo / visuel du projet: image | JPG, PNG, WebP; resized to max 1000 px on the longest side | optional, max 5 MB
- Problématique sociale / environnementale: text | free text | required, 30–2000 characters
- Solution proposée: text | free text | required, 30–2000 characters
- Bénéficiaires: text | free text | required, 10–1000 characters
- Résumé (2–3 lignes): text | free text | required, 30–300 characters
- Accompagnement recherché: select | "Je ne sais pas encore", "Pré-incubation", "Incubation", "Accélération", "Financement" — labelled "À titre indicatif" | optional, default "Je ne sais pas encore" or the FR-15 preset
- Besoins: checkboxes | "Financement", "Partenaires", "Bénévoles", "Mentorat" | optional, multiple; the project's single needs field, also editable by administrators (FR-60)
- Précisions sur vos besoins: text | free text | optional, max 500 characters
- Langue de rédaction: select | "Français", "Arabe" | required, default the interface language

**Rules & Constraints:**
- A step cannot be left with "Continuer" while a required field of that step is empty or invalid; the draft is saved at each successful "Continuer".
- Submission requires a verified e-mail address (FR-01).
- "Besoins" is the project's single needs field: it feeds the public cards (FR-12) and the volunteering and mentoring lists (FR-22, FR-23), and administrators can edit it (FR-60). (The demo saved these needs but never displayed them.)
- A value entered under "Autre (préciser)" is kept and shown everywhere the field appears (the demo lost such values on edit). In filters and statistics it is grouped under "Autre" (FR-12, FR-71).
- An Entrepreneur can own several projects.
- Once oriented, the project is visible to the accredited accompagnateurs of its phase (FR-39); once approved, administrators can publish it (FR-60). Both are covered by the terms of use, without a consent box.

**Edge Cases:**
- Entrepreneur leaves the wizard without "Continuer" → "Quitter sans enregistrer ? Les informations de cette étape seront perdues."; earlier steps stay saved.
- Photo in another format or over 5 MB → "Formats acceptés : JPG, PNG, WebP — 5 Mo maximum."
- Same project name already used by this Entrepreneur → warning "Vous avez déjà un projet portant ce nom."; submission is still possible.
- Draft reopened → the wizard resumes at the last saved step.
- "Soumettre le projet" clicked twice → a single submission is recorded.

---

#### FR-33 — Project Record and Status Tracking

**Description:** An Entrepreneur can follow each project through its statuses, see the next action expected, edit the project's information while it is open to changes, delete a draft and withdraw a project.
*Source: demo `intranet/mon-projet.html` (list and `?id=` record), `intranet/sadmin-projet.html` (timeline and completion bar); v1.0 Q&A Q38, Q94, Q95, Q121.*

**Main Flow:**
1. « Mes projets » lists the Entrepreneur's projects: visual, title, status, « Étape » (phase), « Avancement » (%), and "Soumettre un projet".
2. Opening a project shows the timeline « Où en est mon projet ? » — Soumis → En examen → Orientation → Accompagnement → Terminé, repeated for each phase opened — and a "Prochaine action" button ("Compléter mon dossier", "Corriger les documents", "Revoir mon projet", "Choisir un·e accompagnateur·rice").
3. Tabs: « Informations », « Documents & démarches » (FR-34), « Équipe » (FR-35), « Accompagnement (n) » (FR-37).
4. "Modifier les informations" opens the fields of FR-32 for editing; "Enregistrer" saves them.
5. "Supprimer le brouillon" deletes a draft after confirmation; "Retirer le projet" withdraws a submitted project, with a reason.

**Data & Format:**
- Status (key → Entrepreneur label / back-office label / avancement):
  - `brouillon` → « Brouillon » / « Brouillon » / 10 %
  - `soumis` → « En examen » / « Soumis — à examiner » / 25 %
  - `oriente` → « À compléter » / « Orienté » / 50 %
  - `dossier_soumis` → « En validation » / « Dossier déposé — à valider » / 75 %
  - `approuve` → « Approuvé » / « Approuvé » / 100 % of the current phase
  - `termine` → « Terminé » / « Terminé » / 100 %
  - `refuse` → « Refusé » / « Refusé » / 25 %
  - `retire` → « Retiré » / « Retiré » / percentage at the time of withdrawal
- Motif du retrait: text | free text | required, 10–500 characters
- Editable fields: as in FR-32, same formats and constraints

**Rules & Constraints:**
- Allowed transitions:
  - Brouillon → Soumis (Entrepreneur), or deleted (Entrepreneur);
  - Soumis → Orienté with a phase, or Refusé (Administrator, FR-57);
  - Orienté → Dossier soumis (Entrepreneur, FR-34);
  - Dossier soumis → Approuvé, Refusé, or back to Orienté with documents to correct (Administrator, FR-57);
  - Approuvé → Orienté for the next phase, or Terminé (Administrator, FR-57a);
  - Refusé → Soumis or Orienté (Entrepreneur resubmission, see below), or Orienté (Administrator « Ré-orienter »);
  - any status except Brouillon, Terminé and Retiré → Retiré (Entrepreneur).
- Information can be edited in « Brouillon », « Soumis », « Orienté », « Dossier soumis » and « Refusé ». From « Approuvé » it is locked (« Verrouillé »); later changes go through administrator edit suggestions (FR-59).
- A refused project shows its reason and "Revoir et resoumettre": a project refused at orientation returns to « Soumis »; a project refused at dossier validation returns to « Orienté » with its phase and documents kept.
- Withdrawing a project closes its pending applications and proposals, ends its accompaniments (FR-40), makes its conversations read-only and unpublishes it (FR-60). A withdrawn project is read-only and stays visible to its owner and to administrators.
- Only drafts can be deleted; deletion is permanent.
- « Mes projets » lists every project of the user, with or without a visual; projects where the user is a team member carry the tag "Équipe".
- Every status change and every edit is recorded in the history (FR-56) and notified to the Entrepreneur.

**Edge Cases:**
- Two people edit the same project → the second save shows "Ce projet a été modifié par {nom} à HH:MM. Rechargez la page avant d'enregistrer." and nothing is overwritten.
- The project is approved while the Entrepreneur is editing → the save is rejected with "Ce projet a été approuvé et ne peut plus être modifié."
- The Entrepreneur withdraws the project while an administrator is reviewing it → the administrator's decision is refused with "Ce projet a été retiré par son·sa porteur·se."
- No project → "Vous n'avez pas encore de projet." with "Soumettre un projet".
- Unknown project, or a project of another user → "Accès réservé" page.

---

#### FR-34 — Required Documents and Dossier Submission

**Description:** Once a project is oriented to a phase, its Entrepreneur uploads the documents that phase requires, submits the complete dossier for validation, and corrects the documents an administrator asks to complete.
*Source: demo `intranet/mon-projet.html` (tab « Documents & démarches », `STAGE_DOCS`), `intranet/sadmin-projet.html` (tab « Documents & démarches »); v1.0 Q&A Q85, Q95, Q96.*

**Main Flow:**
1. When the project becomes « Orienté », the tab « Documents & démarches » lists the documents required for its phase, each « À déposer » with "Déposer".
2. Entrepreneur uploads each document; it becomes « Déposé » and can be removed ("Retirer") or replaced ("Remplacer") until the dossier is submitted.
3. When every required document is deposited, "Soumettre le dossier complet" becomes active; clicking it sets the project to « Dossier soumis », the documents to « En attente », and notifies administrators.
4. If an administrator asks for additional documents (FR-57), the project returns to « Orienté »: the documents concerned are marked « À corriger » with the administrator's comment, and the Entrepreneur replaces them and submits again.
5. When an administrator approves the dossier, the documents become « Validé ».

**Data & Format:**
- Required documents per phase (reference list, FR-69b):
  - Pré-incubation: "Proposition de valeur", "Étude rapide de l'idée", "Pitch (1 page)"
  - Incubation: "Business plan", "Business Model Canvas ESS", "Budget prévisionnel", "Pitch deck"
  - Accélération: "Business plan actualisé", "Historique d'activité (traction)", "Prévisionnel 12–24 mois", "Plan d'impact"
  - Financement: "Dossier de financement", "Besoin de financement chiffré", "Business plan", "Pitch deck"
- Document file: file | PDF, DOCX, XLSX, PPTX | required per listed document, max 10 MB, one file per document
- Stored metadata: file name, type, size, upload date-time, uploader

**Rules & Constraints:**
- Documents can be uploaded, removed or replaced only while the project is « Orienté », including after a resubmission or a request for additional documents; they are locked once the dossier is submitted.
- Document states: « À déposer » → « Déposé » → « En attente » (after submission) → « Validé » (after approval), or « À corriger » (after a request for additional documents) → « Déposé » once replaced. If the dossier is refused, documents return to « Déposé ». The back-office shows « Manquant » for documents not deposited.
- When the project moves to its next phase (FR-57a), the documents of the previous phase are kept under « Phases précédentes » and the new phase's list starts at « À déposer ».
- Dossier documents are private: visible to the project's Entrepreneur and team members, to administrators, and to accompagnateurs while they have an accepted accompaniment on the project. They are never published on the public portal.
- Every uploaded file is scanned for malware before it becomes available. While the scanning service is unavailable, the file is accepted but held in quarantine: its uploader sees « En cours de vérification » and nobody else can open it until the scan completes.

**Edge Cases:**
- Administrator re-orients the project to another phase → the new list applies; documents of the former phase are kept under « Autres documents » and do not count.
- Upload interrupted → it resumes where it stopped (FR-04); if it cannot, "Échec du dépôt. Réessayez." and the document stays « À déposer ».
- File rejected by the malware scan → "Ce fichier a été bloqué par le contrôle antivirus."
- "Soumettre le dossier complet" clicked while a document is still in quarantine → "Un document est en cours de vérification. Réessayez dans quelques minutes."
- "Soumettre le dossier complet" clicked with a document missing (e.g. removed in another tab) → "Il manque N document(s) pour soumettre votre dossier."

---

#### FR-35 — Project Team

**Description:** An Entrepreneur can invite co-founders and team members onto a project, follow their invitations, remove them, and transfer the project to one of them.
*Source: demo `intranet/mon-projet.html` (tab « Équipe »), `intranet/sadmin-projet.html` (tab « Équipe »); v1.0 Q&A Q36, Q97, Q130.*

**Main Flow:**
1. Project owner opens the tab « Équipe », clicks "Ajouter un membre", fills one or more rows and clicks "Envoyer l'invitation".
2. System e-mails each invitee a link; the member appears as « Invitation en attente ».
3. Invitee opens the link, signs in or registers as Entrepreneur, and accepts; the member becomes « Actif·ve depuis le DD/MM/YYYY » and the owner is notified.
4. Owner removes a member with "Retirer" after confirmation.
5. Owner clicks "Transférer le projet" and chooses an active member; once that member accepts, they become the owner and the former owner a team member. An administrator can do the same when the owner is unreachable.

**Data & Format:**
- Nom: text | free text | optional, 2–100 characters
- Rôle: text | free text, e.g. "Co-fondatrice" | optional, max 60 characters
- E-mail: text | e-mail address | required, max 254 characters
- Member status: « Invitation en attente » / « Actif·ve »

**Rules & Constraints:**
- Only the project owner invites and removes members and transfers ownership.
- Invitations are valid for 7 days from delivery and can be re-sent; invitation e-mails are queued and retried if the mail service is unavailable.
- A project has at most 10 members besides its owner.
- Team members can view every tab of the project and take part in its conversations (FR-50); they cannot submit, delete or change the team.
- Only an Entrepreneur account can join a team.

**Edge Cases:**
- Invitee's address belongs to an account of another role → "Seul un compte Entrepreneur peut rejoindre l'équipe d'un projet."
- Invitation expired → "Cette invitation a expiré. Demandez une nouvelle invitation au·à la porteur·se du projet."
- Owner invites their own address or an existing member → "Cette personne fait déjà partie de l'équipe."
- Member removed → loses access to the project and its conversations immediately and is notified; a pending invitation link becomes invalid.
- Owner's account deleted (Section 5.5) → an administrator transfers ownership to an active member; without members, the project is unpublished and anonymised.

---

### Module 10 — Accompaniment Matching

#### FR-36 — Accompagnateur Accreditation (Agrément)

**Description:** An Accompagnateur can request the platform accreditation by declaring their experience and proofs; an administrator grants it for 2 years, after which it must be renewed.
*Source: demo `intranet/acc-validation.html`, `intranet/acc-dashboard.html` (badges), `intranet/profil.html` (« Mon agrément »), `intranet/sadmin-utilisateur.html` (tab « Agrément »); v1.0 Q&A Q33, Q34, Q41, Q64, Q99, Q100, Q126.*

**Main Flow:**
1. An Accompagnateur with status « Inactif » sees "Demander mon agrément" on the dashboard and opens the form.
2. Accompagnateur chooses the type of applicant, completes the declaration, the proofs, the past projects, the details and the public presentation, and clicks "Envoyer ma demande".
3. Accreditation status becomes « En examen », the account « En attente de validation »; administrators are notified (FR-70).
4. An administrator decides (FR-54): "Accorder l'agrément" → « Agréé·e » for 2 years, account « Actif », link to the chosen structure confirmed; or "Refuser avec justificatif" → « À revoir » with the reason, account back to « Inactif ». The Accompagnateur is notified.
5. After « À revoir », the Accompagnateur corrects the prefilled form and sends it again.
6. 30 days before expiry, the Accompagnateur is reminded to renew; "Renouveler mon agrément" opens the prefilled form, and the renewal is examined in the same way.

**Data & Format:**
- Type de demandeur: radio | « Personne physique », « Structure » | required
- Fonction / spécialité: text | free text | required, max 150 characters (prefilled from registration)
- Années d'expérience: number | integer | required, 0–60
- Organisation / structure: text | free text | required for « Structure », otherwise optional; max 150 characters
- Structure de rattachement: select | published structures of the directory (FR-69a) | optional
- Zone d'intervention: multi-select | wilaya list + "National" | required, at least 1
- Domaines d'expertise: tags | free text | required, 1–8 tags, max 40 characters each
- Type d'accompagnement: checkboxes | "Pré-incubation", "Incubation", "Accélération", "Financement" | required, at least 1
- Type de preuve: select | "Agrément officiel", "Attestation employeur / structure", "Certification professionnelle", "Références vérifiables" | required
- N° d'agrément / référence: text | free text | max 60 characters; required when no justificatif is attached
- Justificatif d'agrément: file | PDF, DOC, DOCX, JPG, PNG | max 10 MB; required when no number is given
- Pièce d'identité du·de la responsable: file | PDF, JPG, PNG | required, max 10 MB
- Statuts de la structure: file | PDF, DOC, DOCX | required for « Structure », max 10 MB
- Attestation d'expérience: file | PDF, DOC, DOCX, JPG, PNG | optional, max 10 MB
- Lien vérifiable: URL | https://… | optional, max 300 characters
- Projets déjà accompagnés: repeatable group, 1–10 rows | Nom du projet (required, max 100), Porteur / bénéficiaire (max 100), Type (the 4 phases or "Autre"), Année (YYYY, 1990 to current year), Résultat / impact (max 300) | at least 1 row with a name
- Détails de votre accompagnement: text | free text, read by administrators only | required, 30–2000 characters
- Présentation: text | free text, shown to Entrepreneurs (FR-37) | required, 50–1000 characters
- Questions de candidature: 0–3 questions added after the common questionnaire (FR-58a) | each: text max 150 characters, answer type "Texte libre" or "Choix" (2–5 options, max 40 characters each) | optional

**Rules & Constraints:**
- Accreditation states: « À compléter » → « En examen » → « Agréé·e » or « À revoir »; « Agréé·e » → « Expiré » after 2 years without renewal. An « À revoir » request can be resubmitted any number of times.
- Until « Agréé·e », the pages « Accompagnements » and « Messagerie » are locked; « Projets » is visible read-only with the banner "Votre agrément est requis pour proposer un accompagnement."
- An accreditation is valid 2 years from the day it is granted. During a renewal the accompagnateur keeps working normally. Once « Expiré », the accompagnateur can no longer receive applications or propose; accompaniments in progress continue until they are closed (FR-40a).
- The number of places is set by administrators on the account record (FR-53); the accompagnateur sees it but cannot change it.
- After accreditation the declaration is read-only; the « Présentation » and the accompagnateur's own questions remain editable. Changes to organisation or location need administrator approval (FR-05).
- Entrepreneurs see the accredited values — organisation, zone, expertise, phases — and the « Présentation » (FR-37).

**Edge Cases:**
- Neither a justificatif nor a number → "Joignez un justificatif ou indiquez un numéro d'agrément."
- « Structure » without statuts → "Joignez les statuts de la structure."
- No past project named → "Indiquez au moins un projet déjà accompagné."
- File over 10 MB or in another format → "Format non accepté ou fichier trop volumineux (10 Mo maximum)."
- Resubmission after « À revoir » → the previous reason is displayed above the prefilled form.
- Account suspended while « En examen » → the request is frozen and reappears in the queue on reactivation.
- No renewal submitted by the expiry date → the accreditation becomes « Expiré » and the accompagnateur is notified.

---

#### FR-37 — Applying to a Shortlisted Accompagnateur

**Description:** Once a project is approved and an administrator has shortlisted accompagnateurs for it, the Entrepreneur can apply to one or more of them.
*Source: demo `intranet/accompagnement.html`, `intranet/accompagnateur.html`, `intranet/mon-projet.html` (tab « Accompagnement »); v1.0 Q&A Q34, Q100, Q101, Q102, Q126.*

**Main Flow:**
1. The Entrepreneur receives the task "Choisir un·e accompagnateur·rice" once the shortlist exists (FR-58).
2. In "Accompagnement", the approved projects are listed with a status pill; selecting one shows only its shortlisted accompagnateurs, with chips "Tous", "À postuler", "En attente", "Acceptée", "Refusée" when there is more than one.
3. Entrepreneur opens a profile — name, accredited organisation, expertise, phases, zone, places left, « Présentation » — and clicks "Postuler".
4. The modal « Postuler — {nom} » shows the common questionnaire (FR-58a) followed by the accompagnateur's own questions (FR-36); the Entrepreneur answers and sends.
5. The application is « soumise » (shown "En attente de réponse") and the accompagnateur is notified (FR-38).
6. If every shortlisted accompagnateur has refused, "Demander d'élargir la sélection" notifies the administrators (FR-58).

**Data & Format:**
- Answer to a "Texte libre" question: text | free text | required when the question is mandatory, max 500 characters
- Answer to a "Choix" question: radio | one of the question's options | required when the question is mandatory
- Message (when there is no question at all): text | free text | optional, max 1000 characters
- Stored with each application: the text of every question as asked, with its answer
- Project status pill: "Sélection en cours", "À postuler", "En attente de réponse", "Accompagnateur·rice en poste", "Sélection refusée"

**Rules & Constraints:**
- Only « Approuvé » projects with at least one shortlisted accompagnateur can apply, and only to shortlisted accompagnateurs. A direct link to another accompagnateur is refused.
- An Entrepreneur can apply to several shortlisted accompagnateurs at once, with at most one pending application per accompagnateur and project. Whether a project may have more than one accompagnateur at the same time is open (Q7).
- "Postuler" is disabled when the accompagnateur has 0 places left (« Complet »).
- Pending applications close automatically, with a notification to the Entrepreneur, when the accompagnateur has no place left, and — if a project may have only one accompagnateur (Q7) — when another accompagnateur accepts the project.
- If the questionnaire changed while the Entrepreneur was answering, sending is refused with "Le questionnaire a changé, veuillez le relire"; the modal reloads with the new questions and keeps the answers to unchanged questions.
- After a refusal, "Repostuler" is available with the previous answers prefilled.

**Edge Cases:**
- Shortlisted accompagnateur suspended, expired or no longer accredited → the card shows "Indisponible"; pending applications to them are closed and the Entrepreneur is notified.
- "Postuler" sent twice → a single application is recorded.
- Shortlist is empty → "Votre sélection est en cours de préparation par l'équipe de la plateforme."
- Places reach 0 while the modal is open → on send, "Cet·te accompagnateur·rice n'a plus de place disponible."

---

#### FR-38 — Accompagnateur Response to Applications

**Description:** An accredited Accompagnateur can review each application received and accept or refuse it.
*Source: demo `intranet/acc-projet.html`, `intranet/acc-demandes.html` (segment « À traiter »); v1.0 Q&A Q33, Q101, Q103, Q104.*

**Main Flow:**
1. Accompagnateur is notified of a new application and opens it from « À traiter » or the dashboard.
2. The page shows the project's information (summary, phase, sector, wilaya, needs) and the Entrepreneur's answers.
3. "Accepter" → status « acceptée »; a confirmation with "Annuler" stays available for 10 seconds; then the Entrepreneur is notified, a conversation opens (FR-50) and places left decrease by 1.
4. "Refuser" → reason required → status « refusée »; the Entrepreneur is notified with the reason.

**Data & Format:**
- Motif du refus: text | free text | required, 10–500 characters

**Rules & Constraints:**
- Only accredited (« Agréé·e ») accompagnateurs respond, and only to applications addressed to them.
- Accepting requires at least 1 place left (capacity set by administrators, FR-53); accepting the last place shows the accompagnateur as « Complet » and closes their other pending applications (FR-37). Places are counted atomically: of two simultaneous acceptances for the last place, the second is refused.
- The acceptance becomes final 10 seconds after "Accepter" unless "Annuler" is clicked; the server completes it even if the browser is closed meanwhile. An accepted accompaniment ends through FR-40 or FR-40a.
- Dossier documents become visible to the accompagnateur once the application is accepted (FR-34).
- An application unanswered for 7 days triggers a reminder to the accompagnateur; applications do not expire.

**Edge Cases:**
- Project no longer approved (re-oriented or refused) → "Ce projet n'est plus disponible." and the application is closed.
- Decision already taken in another tab → "Cette demande a déjà été traitée."
- No place left when clicking "Accepter" → "Vous n'avez plus de place disponible. L'équipe de la plateforme peut augmenter votre capacité."

---

#### FR-39 — Accompagnateur-Initiated Proposals

**Description:** An accredited Accompagnateur can browse the oriented projects of the phases they are accredited for and propose to accompany one; the Entrepreneur accepts or refuses.
*Source: demo `intranet/acc-projets.html`, `intranet/acc-projet.html` (« Proposer un accompagnement »), `intranet/demandes-accompagnement.html`, `intranet/accompagnateur.html?prop=`; v1.0 Q&A Q35, Q63, Q104, Q105.*

**Main Flow:**
1. Accompagnateur opens "Projets" (« Projets à accompagner »): projects with status « Orienté », « Dossier soumis » or « Approuvé » whose phase is one of the accompagnateur's accredited phases, with no existing relation with this accompagnateur; filters Secteur and Parcours.
2. Accompagnateur opens a project and clicks "Proposer un accompagnement", writes a message and sends.
3. The proposal is « proposée »; the Entrepreneur is notified and finds it in « Demandes reçues », grouped by project.
4. Entrepreneur clicks "Accepter" → « acceptée », a conversation opens; or "Refuser" with a reason → « refusée »; the accompagnateur is notified.

**Data & Format:**
- Message: text | free text | required, 20–1000 characters
- Secteur: select | "Toutes les filières" + sector list | default all
- Parcours: select | "Tous mes parcours" + the accompagnateur's accredited phases | default all
- Motif du refus (Entrepreneur): text | free text | required, 10–500 characters

**Rules & Constraints:**
- Every oriented project is visible to the accredited accompagnateurs of its phase; the Entrepreneur's consent is covered by the terms of use, without an opt-in.
- Proposals are possible from orientation onwards, so an accompagnateur can help build the dossier; applications by the Entrepreneur open only after approval (FR-37).
- No new proposal is possible while a « proposée » or « acceptée » relation exists between the same accompagnateur and project.
- A proposal unanswered for 7 days triggers a reminder to the Entrepreneur; proposals do not expire.

**Edge Cases:**
- Project withdrawn (FR-33) or refused while a proposal is pending → the proposal closes and the accompagnateur is notified.
- Accompagnateur without accreditation, or whose accreditation has expired → banner "Votre agrément est requis pour proposer un accompagnement." and no button.
- No project matches the filters → "Aucun projet ne correspond à vos filtres."

---

#### FR-40 — Ending an Accompaniment Early

**Description:** The Accompagnateur or the Entrepreneur can ask to end an accepted accompaniment before its normal close; an administrator accepts or refuses the request.
*Source: demo `intranet/acc-projet.html` (menu « ⋯ » → « Annuler mon accompagnement »), `intranet/acc-dashboard.html` (pending cancellations banner); v1.0 Q&A Q37, Q123.*

**Main Flow:**
1. The Accompagnateur ("⋯" → "Annuler mon accompagnement") or the project owner ("⋯" → "Mettre fin à l'accompagnement") enters a reason and confirms.
2. The request is « En attente »; administrators and the other party are notified; the accompaniment continues meanwhile.
3. An administrator accepts it (FR-70 queue) → the accompaniment becomes « annulée », its conversation becomes read-only, dossier access ends and the place is freed; or refuses it with a reason → the accompaniment stays « acceptée ».
4. Both parties are notified of the decision.

**Data & Format:**
- Motif: text | free text | required, 10–500 characters
- Motif du refus (Administrator): text | free text | required, 10–500 characters

**Rules & Constraints:**
- Only an « acceptée » accompaniment can be the subject of a request, with one pending request at a time.
- An accepted request is final; resuming requires a new application or proposal.
- An accompaniment also ends automatically (« annulée », both parties notified) when its project is refused, re-oriented or withdrawn (FR-57, FR-33).
- The normal end of an accompaniment is its closure by the accompagnateur (FR-40a).

**Edge Cases:**
- Accompagnateur suspended → their accepted accompaniments appear in the administrator's list of live items (FR-54), where an administrator can end them with a reason.
- Request already decided in another tab → "Cette demande a déjà été traitée."
- Accompaniment closed (FR-40a) while a request is pending → the request closes without a decision.
- No accepted accompaniment → the "⋯" menu does not offer to end it.

---

#### FR-40a — Closing an Accompaniment

**Description:** An accompagnateur closes an accompaniment that has reached its end and records its outcome; the place is freed and, when the phase is complete, administrators are asked to confirm it.
*Source: v1.0 Q&A Q121, Q122 (not in the demo).*

**Main Flow:**
1. Accompagnateur opens an accepted accompaniment and chooses "Clôturer l'accompagnement".
2. Accompagnateur selects the outcome, writes a summary and confirms.
3. The accompaniment becomes « Terminé »: the place is freed, the conversation becomes read-only, dossier access ends, and the Entrepreneur is notified.
4. If the outcome is « Phase terminée », the project enters the administrators' queue « Phases à confirmer » (FR-57a).

**Data & Format:**
- Résultat: select | "Phase terminée", "Projet arrêté par le·la porteur·se", "Réorientation recommandée", "Autre" | required
- Synthèse: text | free text | required, 30–2000 characters
- Stored: closing date, outcome, summary, author

**Rules & Constraints:**
- Only the accompagnateur of an « acceptée » accompaniment can close it; an Entrepreneur who wants it to end uses FR-40.
- Closing is final and recorded in the history (FR-56); the summary is visible to the Entrepreneur and to administrators.
- Closed accompaniments count in « Accompagnements terminés » (FR-41) and in the statistics (FR-71).

**Edge Cases:**
- A request to end the accompaniment early (FR-40) is pending → closing ends the request without a decision.
- Project withdrawn in the meantime → "Ce projet a été retiré ; l'accompagnement est déjà clôturé."
- "Clôturer" clicked twice → a single closure is recorded.

---

#### FR-41 — Accompagnateur Dashboard and Request Tracking

**Description:** An Accompagnateur sees the state of the accreditation, the requests waiting for them, and every accompaniment by status.
*Source: demo `intranet/acc-dashboard.html`, `intranet/acc-demandes.html`; v1.0 Q&A Q99, Q122.*

**Main Flow:**
1. Accompagnateur signs in to the dashboard showing the accreditation badge (« Agréé·e », « En attente », « Non validé », « Expiré ») and a button matching that state.
2. Once accredited: tiles "Demandes à examiner", "Accompagnements acceptés", "Accompagnements terminés", "Demandes refusées", "Demandes reçues (total)" and the places left; an « À faire » list with "Examiner"; « Projets accompagnés » (3); a banner for pending requests to end an accompaniment, with "Voir"; 30 days before expiry, a banner "Votre agrément expire le DD/MM/YYYY" with "Renouveler".
3. Page "Accompagnements": segments "À traiter" (soumise), "Envoyées" (proposée), "En cours" (acceptée), "Terminés" (terminé), "Refusées" (refusée), "Annulés" (annulée), each with its count; a link can open a given segment (?seg=).

**Data & Format:**
- List row: project title, phase, wilaya, date of the request (DD/MM/YYYY), status
- Counts: integers, consistent with the segment lists

**Rules & Constraints:**
- Only the accompagnateur's own relations are counted and listed.
- Without accreditation, tiles are hidden and the button reads "Demander mon agrément" or "Demande en cours d'examen".

**Edge Cases:**
- Empty segment → "Aucune demande dans cette catégorie."
- Accreditation « À revoir » → banner with the reason and "Corriger ma demande".
- Unknown segment in the link → "À traiter" opens.

---

### Module 11 — Citizen Space

#### FR-42 — Citizen Dashboard and Projects to Support

**Description:** A Citizen sees their contributions and trainings and discovers projects they could support.
*Source: demo `intranet/cit-dashboard.html`, `intranet/cit-projets.html`.*

**Main Flow:**
1. Citizen signs in to the dashboard: button "Soutenir un projet"; tiles "Contributions", "Bénévolat", "Projets soutenus", "Formations suivies".
2. « Projets à soutenir » suggests 2 published projects needing volunteers or mentors, in the Citizen's wilaya first, excluding projects already supported; « Mes contributions » shows the 3 latest; « Mes formations » or « Formations recommandées » follows.
3. Page "Projets": search, Secteur, Wilaya, stage chips; cards with "Voir le projet" and "Contribuer" (FR-43).

**Data & Format:**
- Recherche: text | placeholder "Nom, besoin, mot-clé…" | optional, 2–100 characters
- Secteur, Wilaya: select | reference lists | default all
- Stade: chips | "Tous" + public stages (Q1) | default "Tous"

**Rules & Constraints:**
- Only published projects are listed (the demo also listed drafts and refused projects).
- No funding percentage is displayed: the platform collects no money (the demo's « % financé » was a placeholder value).

**Edge Cases:**
- No suggestion available → "Aucun projet à vous suggérer pour le moment." with a link to all projects.
- No contribution yet → "Vous n'avez pas encore proposé de contribution."
- No training → « Formations recommandées » shows 3 published trainings for the audience "Apprenant".

---

#### FR-43 — Contribution Offers and Entrepreneur Decision

**Description:** A Citizen can offer volunteering, mentoring or a donation pledge to a project; the project's Entrepreneur accepts or refuses each offer, and either party can close an accepted contribution.
*Source: demo `intranet/cit-projet.html` (« Contribuer »), `intranet/cit-contributions.html`, `intranet/cit-contribution.html`, `intranet/demandes-accompagnement.html`; UGP feedback V0, « Participation » (sondage, bénévolat, mentorat); donation pledges pending (Q4); v1.0 Q&A Q104, Q106.*

**Main Flow:**
1. Citizen clicks "Contribuer" on a project, or arrives from FR-22 / FR-23; a modal offers the type chips "Bénévolat", "Mentorat" and "Promesse de don".
2. Citizen completes the fields and clicks "Envoyer"; the offer is « soumise » (shown "En attente") and the Entrepreneur is notified.
3. In « Demandes reçues », grouped by project, the Entrepreneur filters with "Tous", "Bénévolat", "Mentorat", "Dons", "Propositions" and opens an offer.
4. "Accepter" → « acceptée », a Citizen–Entrepreneur conversation opens (FR-50), the Citizen is notified; "Refuser" with a reason → « refusée », the Citizen is notified with the reason.
5. Citizen follows offers in « Mes contributions » (chips "En attente", "Acceptées", "Terminées", "Refusées") and opens each: « Ma proposition », the reason if refused, "Contacter le porteur" if accepted.
6. Either party can click "Marquer comme terminée" on an accepted contribution, with an optional short assessment; the contribution becomes « Terminée » and the conversation read-only.

**Data & Format:**
- Type: chips | "Bénévolat", "Mentorat", "Promesse de don" (pending, Q4) | required
- Compétences / disponibilité (Bénévolat): text | free text | required, 10–1000 characters
- Domaines d'expertise (Mentorat): text | free text | required, 3–300 characters
- Années d'expérience (Mentorat): number | integer | required, 0–60
- Disponibilité (Mentorat): select | "1 à 2 h / mois", "3 à 5 h / mois", "Plus de 5 h / mois" | required
- Format (Mentorat): select | "À distance", "Présentiel", "Les deux" | required
- Montant du don (Promesse de don): number | integer in DZD, displayed "10 000 DA" | required, 100–10 000 000
- Message au porteur (optionnel): text | free text | optional, max 1000 characters
- Bilan (when closing): text | free text | optional, max 500 characters
- Motif du refus (Entrepreneur): text | prefilled "Contribution non retenue pour le moment." and editable | required, 10–500 characters

**Rules & Constraints:**
- A Citizen can have one pending offer per project and type.
- Only the project owner decides; administrators can only read (FR-63). (In the demo, donation offers could not be decided from the Entrepreneur's screens.)
- A donation pledge involves no payment on the platform; the modal states "Aucun paiement n'est effectué sur la plateforme. Le·la porteur·se vous contactera."
- An offer unanswered for 14 days triggers a reminder to the Entrepreneur; offers do not expire.
- Offers cannot be sent to showcase projects (FR-60).

**Edge Cases:**
- Project unpublished after the offer → the Entrepreneur can still decide; the Citizen sees "Projet non visible publiquement".
- Amount with letters, spaces or decimals → "Saisissez un montant en dinars, sans décimales."
- Citizen account suspended → their pending offers are hidden from the Entrepreneur until reactivation.
- Offer already decided in another tab → "Cette proposition a déjà été traitée."

---

### Module 12 — Learning & Trainer Space

#### FR-44 — Learner Training Space

**Description:** An Entrepreneur or a Citizen can register for training sessions from their space, follow online lessons, find the practical information of in-person sessions, and join live sessions.
*Source: demo `intranet/formations.html`, `intranet/formation.html`, `intranet/cit-formations.html`; v1.0 Q&A Q60, Q87, Q88, Q107, Q108.*

**Main Flow:**
1. User opens "Formations": tab "Mes formations (n)" — « Prochaines sessions » and « Mes cours en ligne » with "En cours" / "Terminé" — and tab "Toutes les formations" with search, Filière, Format, Niveau and "Tout effacer".
2. User opens a training; in-person and hybrid trainings list their upcoming sessions, each with date, time, place, places left and a button "S'inscrire", "Inscrit·e · Présentiel", "Inscrit·e · En direct", or "Rejoindre la liste d'attente" when full (FR-44a).
3. "S'inscrire" opens the registration modal for the chosen session; the user confirms.
4. Content by format:
   - En ligne: lessons (video, description, supports) and the « Quiz de validation » (FR-45);
   - Présentiel: programme and « Informations pratiques » (Date, Heure, Durée, Lieu) with "Ajouter à mon agenda";
   - Hybride: the same, plus "Rejoindre la session" for remote participants, the quiz and the replays.
5. "Se désinscrire" cancels the registration to a session.

**Data & Format:**
- Séance (Présentiel, Hybride): select | the training's upcoming sessions | required
- Comment souhaitez-vous participer ? (Hybride only): radio | "Sur place", "En direct" | required
- Nom complet: text | prefilled from the profile | required, 2–100 characters
- E-mail: text | prefilled, e-mail address | required, max 254 characters
- Téléphone: text | 0XXXXXXXXX or +213XXXXXXXXX | required
- Votre objectif: select | "Monter en compétences", "Avancer sur mon projet", "Découvrir le sujet", "Autre" | optional; stored
- « Je m'engage à être présent·e à la séance. » (on-site participation): checkbox | — | required
- Ajouter à mon agenda: file | .ics calendar event with title, date, time, place

**Rules & Constraints:**
- Lessons and quiz are available only to registered users.
- On-site registration is blocked when a session's places left reach 0; the user can join its waiting list (FR-44a). The last place is allocated atomically and shared with guest registrations (FR-20).
- Online and hybrid trainings: status "En cours" after registration, "Terminé" once the quiz is passed (FR-45). In-person trainings: "Terminé" once the session date has passed, pending the client's answer on attendance (Q6).
- Lesson progress is saved on the server.
- "Se désinscrire" is available until the session starts; the freed place is offered to the waiting list (FR-44a).
- Registration from the learning space is open to Entrepreneur and Citizen accounts.

**Edge Cases:**
- Training withdrawn after registration → the user is notified and the training shows "Cette formation n'est plus disponible."
- Session already started → "Se désinscrire" is hidden.
- Joining link not yet available → "Le lien de la session sera disponible 15 minutes avant le début."
- Lesson video unavailable → "La vidéo n'est pas disponible pour le moment."; the description and supports remain readable.
- Session date, time or place changed after registration (FR-48a) → the user is e-mailed and can unregister.

---

#### FR-44a — Waiting List

**Description:** When a training session is full, a person can join its waiting list and is offered a freed place in turn.
*Source: v1.0 Q&A Q108 (not in the demo).*

**Main Flow:**
1. On a full session, the person clicks "Rejoindre la liste d'attente" and confirms their details, as for a registration (FR-20 for guests, FR-44 for members).
2. System records the request with its position and confirms: "Vous êtes N° X sur la liste d'attente."
3. When a place frees up, the first person on the list is notified by e-mail, and in the platform if signed in, and has 48 hours to click "Confirmer ma place".
4. On confirmation the person is registered; without confirmation within 48 hours, the place is offered to the next person.

**Data & Format:**
- Registration fields: as in FR-20 (guests) or FR-44 (members), same formats and constraints
- Position: integer | 1–999 | computed
- Délai de confirmation: date-time | DD/MM/YYYY HH:MM | 48 hours after the offer is delivered

**Rules & Constraints:**
- One entry per person (e-mail address) per session; a person already registered cannot join the list.
- Places are offered in list order, one offer per freed place; the waiting list closes when the session starts.
- "Quitter la liste d'attente" is possible at any time and moves the following people up.

**Edge Cases:**
- Two places free at the same time → the first two people each receive an offer.
- An offer is made less than 48 hours before the session → its deadline is cut to the session start.
- Session cancelled → everyone on the list is e-mailed and the list is cleared.
- Confirmation after the deadline → "Cette offre a expiré ; la place a été proposée à la personne suivante."

---

#### FR-45 — Training Quiz

**Description:** A registered learner can take the validation quiz of an online or hybrid training, see the result and retake it.
*Source: demo `intranet/formation-quiz.html`; v1.0 Q&A Q59, Q107.*

**Main Flow:**
1. A registered learner opens « Quiz de validation ».
2. System draws 5 questions at random from the training's question bank and shows them one at a time; each question states how many answers to select.
3. Learner answers every question and submits.
4. System shows the score and "Réussi" or "À repasser", and lists which questions were answered incorrectly without revealing the right answers.
5. "Repasser le quiz" draws a new set of questions.

**Data & Format:**
- Answer: radio or checkboxes | exactly the number of answers indicated by the question | required for each question
- Seuil de réussite: integer | 1–100 % | set by the Trainer for each training (FR-48), default 60 %

**Rules & Constraints:**
- The question bank is the one written by the training's Trainer (FR-48). (The demo drew from a generic pool and never used the Trainer's questions.)
- Scoring is all-or-nothing per question; score = correct questions ÷ questions drawn.
- Attempts are unlimited; the latest attempt is recorded with its date. Once passed, the training stays "Terminé" even if a later attempt fails.
- When the bank holds fewer than 5 questions, all of them are used (a training cannot be published with fewer than 3, FR-48).

**Edge Cases:**
- Learner not registered → "Inscrivez-vous à la formation pour accéder au quiz."
- Wrong number of answers selected → "Sélectionnez N réponse(s)."; the learner cannot move on.
- Learner leaves during the quiz → the attempt is discarded; the next start draws a new set.
- Training withdrawn during the quiz → on submit "Cette formation n'est plus disponible."

---

#### FR-46 — Trainer Qualification

**Description:** A Trainer follows the qualification course and passes the qualification test before creating trainings.
*Source: demo `intranet/formateur-qualification.html`; back-office `intranet/sadmin-qualification.html`, `sadmin-qualif-formation.html`, `sadmin-qualif-test.html`.*

**Main Flow:**
1. A Trainer with status « Qualification à passer » opens "Ma qualification": the course « Devenir formateur·rice à l'Académie ESS » with its lessons (FR-62) and the « Test de validation », marked « Verrouillé ».
2. Trainer opens each lesson (video, description, supports); an opened lesson is marked done.
3. When every lesson is done, the test unlocks; the system draws 6 questions at random from the bank.
4. Trainer answers and submits; the system compares the score with the pass mark.
5. "Réussi" → account « En attente de validation », administrators notified (FR-70), button "Ajouter une formation"; failure → "Refaire le test".

**Data & Format:**
- Choice answer: checkboxes | options of the question | required
- Typed answer: text | free text, compared with the accepted answers ignoring case and accents | required, max 200 characters
- Seuil de réussite: integer | 1–100 %, step 5 | set by administrators (FR-62), default 60 %

**Rules & Constraints:**
- The score is computed on the 6 questions drawn. (The demo used the 6 drawn questions on one screen and the whole bank on another.)
- Attempts are unlimited; each attempt draws a new set; the latest result is recorded with its date.
- Lesson progress is saved on the server.
- Passing the test unlocks training authoring (FR-48); administrator validation of the account is still required for the pedagogical kit (FR-47).

**Edge Cases:**
- Bank holds fewer than 6 questions → "Le test n'est pas encore disponible."; administrators see the warning of FR-62.
- Lesson added after the Trainer passed → shown with the tag "Nouveau"; the Trainer's status is unchanged.
- Pass mark changed by an administrator → applies to attempts started after the change.
- Trainer leaves during the test → the attempt is discarded.

---

#### FR-47 — Pedagogical Kit

**Description:** A validated Trainer can read and download the pedagogical kit distributed by administrators.
*Source: demo `intranet/formateur-kit.html`; back-office `intranet/sadmin-kit.html`; meeting notes of 23 September (« accès au kit pédagogique après validation du formateur »).*

**Main Flow:**
1. A Trainer whose account is « Actif » opens "Kit pédagogique": the distributed documents with title, description, type, size and related lesson.
2. "Lire" opens the document in the browser viewer; "Télécharger" downloads it.
3. When administrators distribute a new document, every validated Trainer is notified.

**Data & Format:**
- Document (displayed): title max 120 characters; description max 500 characters; type PDF, DOCX, PPTX, XLSX, MP4 or MOV; size in KB or MB

**Rules & Constraints:**
- The kit is available only to Trainers whose account an administrator has validated (« Actif »); the demo did not lock this page.
- Withdrawn documents disappear from the kit immediately.
- Each download is recorded with the Trainer and the date (FR-56).

**Edge Cases:**
- Trainer not yet validated → lock screen "Le kit pédagogique est accessible après la validation de votre profil."
- Format that cannot be read in the browser (DOCX, XLSX) → only "Télécharger" is offered.
- File missing from storage → "Document momentanément indisponible."
- Kit empty → "Aucun document dans le kit pour le moment."

---

#### FR-48 — Trainer Authoring and Submission of Trainings

**Description:** A qualified Trainer can create a training — online, in-person or hybrid — save it as a draft, submit it for validation, revise it, and request its deletion.
*Source: demo `intranet/formateur-formation.html`, `intranet/formateur-formations.html`; back-office `intranet/sadmin-formation.html`; v1.0 Q&A Q9, Q14, Q59, Q61, Q62, Q66, Q87, Q109.*

**Main Flow:**
1. Trainer clicks "Ajouter une formation" and chooses the type; the steps are:
   - En ligne: « Informations de la formation », « Modules et contenu », « Quiz »;
   - Présentiel: « Informations de la formation », « Programme et séances »;
   - Hybride: all four.
2. "Enregistrer le brouillon" saves at any step.
3. "Envoyer pour validation" sets the training to « En validation » and notifies administrators (FR-70).
4. Administrator decides (FR-61): « Validée » → published in the catalogue (FR-18); « À revoir » with a reason → the Trainer edits and clicks "Modifier et renvoyer".
5. On a training « En validation » or « Validée », "Demander la suppression" sends a justified request; "Retirer ma demande" cancels it while pending.

**Data & Format:**
- Nom de la formation: text | free text | required, 5–120 characters
- Thématique: select | the 12 Académie thematics (FR-69b) | required
- Filière: select | "Agriculture", "Santé", "Numérique", "Artisanat", "Autre" | required
- Type de formation: select | "En ligne", "Présentiel", "Hybride" | required
- Niveau: select | "Débutant", "Intermédiaire", "Avancé" | required
- Public: select | "Apprenant", "Porteur de projet", "Formateur" | required
- Durée (En ligne, Hybride): number | hours, 0.5–200, step 0.5 | required
- Objectifs pédagogiques: list | 1–8 items, max 200 characters each | required
- Prérequis: text | free text | optional, max 500 characters
- Vignette: image | JPG, PNG, WebP | required, max 5 MB
- Résumé court: text | free text | required, 30–300 characters
- Module (En ligne, Hybride): Titre du module (required, max 120 characters); Description (max 2000 characters); Vidéo (MP4 file max 500 MB, or YouTube / Vimeo URL); Supports (0–10, each "PDF" file max 10 MB or "Lien" URL, with a name of max 100 characters)
- Quiz question (En ligne, Hybride): text max 300 characters; 2–4 options of max 150 characters; at least 1 correct and 1 incorrect option
- Seuil de réussite (En ligne, Hybride): number | integer 1–100 % | required, default 60
- Programme (Présentiel, Hybride): 1–20 lines, max 200 characters each; optional programme PDF, max 10 MB
- Séances (Présentiel, Hybride): 1–20 sessions, each with Date (DD/MM/YYYY, future), Heure (HH:MM), Durée (hours), Lieu (max 200 characters), Nombre de places (integer 1–500), Lien de la carte (URL, optional) | at least 1 complete session required
- Lien de connexion (Hybride, per session): URL | https://…, link of the tool chosen by the Trainer | required
- Justification de la demande de suppression: text | free text | required, 10–500 characters

**Rules & Constraints:**
- Only Trainers who passed the qualification (FR-46) can create trainings; administrators can also create catalogue trainings (FR-61a).
- A draft needs only a title. Submission requires: name, thematic, filière, summary, thumbnail and objectives; for Présentiel also at least 1 programme line and 1 complete session; for En ligne also duration, at least 1 titled module, at least 3 valid questions and a pass mark; Hybride needs all of these plus each session's joining link.
- Statuses: `brouillon` « Brouillon » → `soumise` « En validation » → `validee` « Validée » (published) or `refusee` « À revoir »; « À revoir » → « En validation » after revision.
- A Trainer can delete their own drafts directly.
- Editing a « Validée » training sends the changes for validation; the published version stays online unchanged until they are approved. Adding a session to a validated training needs no new validation (FR-48a).
- When an approved change affects a session's date, time, place or joining link, every registrant of that session is e-mailed, with a link to cancel.
- During a deletion request the training stays online; an accepted request removes it and notifies its registrants; a refused request shows the administrator's reason.
- A new training form opens empty.

**Edge Cases:**
- Session date in the past → "La date de la séance doit être dans le futur."
- Question with only correct options → "Chaque question doit comporter au moins une réponse incorrecte."
- Places of a session reduced below its registrants → "Le nombre de places ne peut pas être inférieur au nombre d'inscrit·e·s (N)."
- Video upload interrupted → it resumes where it stopped (FR-04); if it cannot, the module is saved without video and "Échec de l'envoi de la vidéo. Réessayez." is shown.
- Trainer suspended while a training is « En validation » → the request stays in the queue; the administrator decides as usual.

---

#### FR-48a — Training Sessions

**Description:** A Trainer — or an administrator, for catalogue trainings — can add sessions to a validated training without a new validation, and cancel a session with its registrants informed.
*Source: v1.0 Q&A Q87, Q109 (not in the demo).*

**Main Flow:**
1. On a « Validée » in-person or hybrid training, the Trainer opens « Séances » and clicks "Ajouter une séance".
2. Trainer enters the session's details and saves; the session is published at once in the catalogue (FR-18, FR-19).
3. To cancel a session, the Trainer clicks "Annuler la séance" and gives a reason; registrants and the waiting list (FR-44a) are e-mailed.
4. Changes to an existing session's date, time, place or joining link go through validation (FR-48); once approved, registrants are e-mailed.

**Data & Format:**
- Date: date | DD/MM/YYYY, in the future | required
- Heure: time | HH:MM | required
- Durée: number | hours, 0.5–24 | required
- Lieu: text | free text | required for on-site participation, max 200 characters
- Nombre de places: number | integer 1–500 | required
- Lien de connexion (Hybride): URL | https://… | required
- Lien de la carte: URL | https://… | optional
- Motif de l'annulation: text | free text | required, 10–500 characters

**Rules & Constraints:**
- A training holds at most 20 upcoming sessions.
- Past sessions are read-only and stay in the history; an in-person or hybrid training appears in the catalogue only while it has at least one upcoming session.
- A session with registrants cannot be deleted, only cancelled.

**Edge Cases:**
- Two sessions at the same date, time and place → warning "Une séance existe déjà à cette date et à ce lieu." (saving allowed).
- Session cancelled less than 24 hours before its start → registrants are e-mailed immediately and also notified in the platform.
- Training withdrawn (FR-61) → all its upcoming sessions are cancelled and their registrants informed.

---

#### FR-49 — Trainer Dashboard and Agenda

**Description:** A Trainer sees the status of their trainings and the calendar of their upcoming sessions.
*Source: demo `intranet/formateur.html`, `intranet/formateur-formations.html`, `intranet/formateur-agenda.html`.*

**Main Flow:**
1. Trainer signs in to the dashboard: button "Ajouter une formation"; tiles "Formations créées", "En validation", "Validées", "À revoir"; tasks; agenda preview; « Formations en attente ».
2. "Mes formations" lists the Trainer's trainings with chips "Toutes", "Brouillons", "En validation", "Validées", "À revoir" and filters Filière, Format, Niveau.
3. "Mon agenda" shows the validated in-person and hybrid sessions — including those of trainings assigned to the Trainer by administrators (FR-61a) — grouped by month, upcoming first, with date, time, place and "N inscrit·e·s / N places"; past sessions are under « Sessions passées ».

**Data & Format:**
- Agenda row: date DD/MM/YYYY; time HH:MM; place max 200 characters; registrations as integer / places as integer

**Rules & Constraints:**
- Before the qualification is passed, "Ajouter une formation" opens the modal « Passez d'abord votre qualification » and "Mes formations" is locked.
- The agenda shows only the Trainer's own validated sessions.
- Past sessions are never shown as upcoming (the demo listed them as « à venir »).

**Edge Cases:**
- No training yet → "Vous n'avez pas encore créé de formation."
- No session scheduled → "Aucune session programmée."
- A session is withdrawn by an administrator → it leaves the agenda and the Trainer is notified.

---

### Module 13 — Messaging & Notifications

#### FR-50 — Messaging

**Description:** Users linked by an accepted relation — and administrators with any user — can exchange messages in conversations attached to a project or a training.
*Source: demo `intranet/messagerie.html`, `intranet/acc-messagerie.html`, `intranet/cit-messagerie.html`, `intranet/sadmin-messagerie.html` (tab « Conversations »); v1.0 Q&A Q53, Q110.*

**Main Flow:**
1. User opens "Messagerie": conversations with participants, related project, last message and unread count; a search field.
2. User opens a conversation, reads the history, writes a message and clicks "Envoyer". A participant can report the conversation with "Signaler" (FR-50a).
3. Participants see the message immediately in an open conversation, and as a notification otherwise (FR-51).
4. Entrepreneur: "Ajouter un·e membre de l'équipe" adds an active team member to a project conversation; a system message records it.
5. Administrator: "Nouvelle conversation" → search an account by name, role or e-mail → optional "Référencer un dossier" (project or training) → "Ouvrir la conversation"; "Ajouter quelqu'un — crée un groupe"; remove members, keeping at least 2; "Supprimer la conversation" hides it on the administrator side only.

**Data & Format:**
- Message: text | plain text, line breaks kept, links made clickable | 1–2000 characters
- Conversation types: Projet–Accompagnateur (one per project and accompagnateur); Projet–Citoyen (one per project and citizen); Administration (opened by an administrator, one-to-one or group)
- Search: text | matched on participant names and project title | 2–100 characters

**Rules & Constraints:**
- A Projet–Accompagnateur conversation exists only for an accepted accompaniment, and both sides see the same thread. (In the demo the Entrepreneur and the accompagnateur wrote in two separate threads.)
- A Projet–Citoyen conversation exists only after an accepted offer, and appears in both the Citizen's and the Entrepreneur's inbox.
- Outside these relations, users cannot start conversations; administrators can contact any account.
- An Accompagnateur without accreditation has no access to messaging.
- When a relation ends (accompaniment « annulée » or « Terminé », contribution « Terminée », project withdrawn, member removed, conversation closed by an administrator), the conversation becomes read-only with "Cette conversation est fermée."; a removed member loses access.
- Attachments are not supported; documents go through the project dossier (FR-34).

**Edge Cases:**
- Recipient suspended → "Ce·tte destinataire n'est plus disponible."; the message is not sent.
- Sending fails (network) → the message is shown "Non envoyé" with "Réessayer".
- Empty message → "Envoyer" is disabled.
- More than 2000 characters → a counter turns red and "Envoyer" is disabled.

---

#### FR-50a — Reporting a Conversation

**Description:** Any participant can report a conversation to administrators, who can close it.
*Source: v1.0 Q&A Q110 (not in the demo).*

**Main Flow:**
1. In a conversation, the user clicks "Signaler", chooses a reason, adds a comment and sends.
2. The report reaches the administrators' queue « Conversations signalées » (FR-70) together with the last 20 messages of the conversation.
3. An administrator reviews it and either closes the conversation ("Clôturer la conversation", read-only for every participant) or dismisses the report ("Classer sans suite"), with a comment.
4. The reporting user is notified of the outcome.

**Data & Format:**
- Motif: select | "Harcèlement ou propos offensants", "Demande d'argent ou fraude", "Contenu inapproprié", "Autre" | required
- Commentaire: text | free text | required for "Autre", otherwise optional; max 1000 characters
- Décision (Administrator): "Clôturer la conversation" or "Classer sans suite", with a comment of 10–500 characters | required

**Rules & Constraints:**
- The reported user is not told who reported the conversation.
- A closed conversation cannot be reopened by its participants; an administrator can reopen it.
- Reports require the scope "Messagerie & annonces"; every decision is recorded (FR-56).

**Edge Cases:**
- The same conversation reported twice → the reports are grouped under one queue item.
- Conversation already closed for another reason (FR-40, FR-40a) → the report is still reviewed; closing has no further effect.
- Reporter deletes their account before the decision → the report stays in the queue.

---

#### FR-51 — Notifications

**Description:** A signed-in user is told in real time of every event that concerns them, in the platform and by e-mail, according to the channels set by Super-administrators.
*Source: demo `intranet/notifications.html` and the top-bar bell; TDR (« notification instantanée »); v1.0 Q&A Q16, Q111, Q134.*

**Main Flow:**
1. An event concerning a user occurs; the system creates a notification with icon, text, date-time and link, on the channels active for that type.
2. The bell icon shows the unread count; opening it lists the 10 latest and marks them read.
3. "Voir toutes les notifications" opens the notifications page: all notifications and announcements (tag "Annonce"), unread count, "Tout marquer comme lu".
4. Clicking a notification opens the related item.

**Data & Format:**
- Notification: icon; text max 200 characters; date-time; link; read flag
- Events, recipients and default e-mail setting:

| Event | Recipients | E-mail by default |
|---|---|---|
| Account validated, refused, suspended, reactivated | Account holder | Yes |
| Refusal contested | Administrators in scope | No |
| Project submitted; dossier submitted | Administrators in scope | No |
| Project oriented, refused, approved; additional documents requested | Entrepreneur and team | Yes |
| Phase completion to confirm | Administrators in scope | No |
| Next phase opened; project « Terminé » | Entrepreneur and team | Yes |
| Shortlist available | Entrepreneur | Yes |
| Application received / accepted / refused / closed automatically | Accompagnateur / Entrepreneur | Yes |
| Proposal received / accepted / refused | Entrepreneur / Accompagnateur | Yes |
| Early end requested / decided; accompaniment closed | Accompagnateur, Entrepreneur, administrators | Yes |
| Contribution offer received / decided / closed | Entrepreneur / Citizen | Yes |
| Team invitation accepted; member removed; ownership transferred | Owner / removed member / new owner | No / Yes / Yes |
| Accreditation granted, « À revoir », expiring in 30 days, expired | Accompagnateur | Yes |
| Qualification passed; Trainer CV or diplomas changed | Administrators | No |
| Training validated, « À revoir », withdrawn, deletion decided | Trainer (and registrants when withdrawn or deleted) | Yes |
| Session changed or cancelled; waiting-list place offered | Registrants / person offered the place | Yes |
| Edit suggestion received / answered | User / Administrator | Yes / No |
| Conversation reported / closed | Administrators / participants | No / Yes |
| New message | Conversation participants | Yes, if still unread after 1 hour; at most 1 e-mail per conversation per day |
| Reminder (application 7 days, proposal 7 days, offer 14 days) | Person expected to answer | Yes |
| Announcement | Targeted accounts | No |

**Rules & Constraints:**
- A connected user receives a notification within 10 seconds without reloading the page.
- In the platform settings (FR-69c), Super-administrators switch each notification type on or off and choose its channels — in the platform, by e-mail, or both; the table above gives the defaults. Users cannot change these settings.
- Account and security e-mails — verification, password reset, sign-in code, change of e-mail address — are always sent and cannot be switched off.
- E-mails are sent in the account's language and contain a link to the related item.
- Notifications are kept 12 months (pending validation, Q20).
- The dashboard link "Voir toutes les notifications" opens the notifications page.

**Edge Cases:**
- Related item deleted → "Cet élément n'est plus disponible."
- E-mail delivery fails → the in-platform notification is kept; the e-mail is retried 3 times within 1 hour and the failure is logged.
- Notification type switched off → no new notification of that type is created; those already received stay.
- More than 99 unread → the badge shows "99+".

---

#### FR-52 — Announcements

**Description:** An administrator can broadcast an announcement to accounts selected by role, account status and wilaya.
*Source: demo `intranet/sadmin-messagerie.html` (tab « Annonces »), `intranet/notifications.html` (tag « Annonce »); v1.0 Q&A Q112.*

**Main Flow:**
1. Administrator opens "Messagerie" → "Annonces" → "Diffuser une annonce".
2. Administrator writes the title and message and chooses the audience; the number of recipients updates live.
3. "Diffuser" asks "Diffuser à N comptes ?"; on confirmation, the announcement reaches each recipient's notifications with the tag "Annonce".
4. The list of sent announcements shows title, reach, date, author and "Retirer cette annonce".

**Data & Format:**
- Titre: text | free text | required, 5–120 characters
- Message: text | free text | required, 10–2000 characters
- À qui ?: checkboxes | "Entrepreneurs", "Accompagnateur·rice·s", "Formateur·rice·s", "Citoyen·ne·s", "Administration" | none ticked = every role
- Statut du compte: select | "Tous les statuts", "Comptes actifs", "En attente de validation", "Comptes suspendus" | default "Tous les statuts"
- Wilaya: multi-select | "Toutes les wilayas" + wilaya list | default all

**Rules & Constraints:**
- Recipients are the accounts matching the roles AND the status AND the wilayas. (The demo applied the role filter only.)
- Sending is blocked when the audience counts 0 accounts.
- Accounts without a wilaya (administrators) are not excluded by the wilaya filter.
- Delivery runs in the background; the sender sees "Diffusion en cours (N/M)" until it completes.
- "Retirer cette annonce" removes it from every inbox; it stays in the administrator's list marked « Retirée ».

**Edge Cases:**
- An account changes role or status after the announcement → it keeps the announcements already received.
- Suspended accounts targeted → they see the announcement after reactivation.
- Delivery interrupted → it resumes automatically from the first undelivered account; nobody receives it twice.

---

#### FR-52a — Contact Inbox

**Description:** Administrators can read, answer and track the messages sent through the contact form.
*Source: v1.0 Q&A Q46 (not in the demo).*

**Main Flow:**
1. Administrator opens "Messagerie" → "Messages de contact": list with date, name, e-mail, subject and status.
2. Administrator opens a message, writes an answer and clicks "Répondre"; the answer is e-mailed to the sender and the message becomes « Traité ».
3. Administrator can also mark a message « Traité » without answering, or assign it to a colleague ("Attribuer à").

**Data & Format:**
- Statut: « Nouveau », « En cours », « Traité »
- Réponse: text | free text | required to answer, 10–5000 characters
- Attribuer à: select | administrators with the scope "Messagerie & annonces"
- Filters: Statut; Période (DD/MM/YYYY – DD/MM/YYYY); Recherche on name, e-mail and subject (2–100 characters)

**Rules & Constraints:**
- Each contact message is also e-mailed to the mailbox set in the platform settings (FR-69c); its address is pending the client's answer (Q19).
- Messages are kept 12 months, then deleted (pending validation, Q20).
- The inbox requires the scope "Messagerie & annonces"; answers are recorded (FR-56).

**Edge Cases:**
- Two administrators answer the same message → the second sees "Ce message a déjà reçu une réponse de {nom}."
- Sender's address bounces → the message shows "Réponse non délivrée".
- No message → "Aucun message de contact."

---

### Module 14 — Back-office: Users & Administrators

#### FR-53 — Account Directory and Account Record

**Description:** An administrator can find any user account by role, status or keyword and open a record showing the person's information, activity and pending requests.
*Source: demo `intranet/sadmin-utilisateurs.html`, `intranet/sadmin-utilisateur.html`; v1.0 Q&A Q33, Q70, Q98, Q126.*

**Main Flow:**
1. Administrator opens "Utilisateurs" and chooses a sub-entry: "Entrepreneurs / ESS", "Accompagnateur·rice·s", "Formateur·rice·s" or "Citoyen·ne·s"; tiles show "Comptes", "Actifs", "En attente", "Suspendus / refusés".
2. Administrator searches ("Rechercher un compte…") and filters with status chips ("Tous" + statuses present).
3. Clicking a row opens the account record: identity card (status, decision buttons, "Contacter", shortcuts to pending items, verification badges), tab « Informations personnelles », the role's tabs and tab « Historique »; a pager moves to the previous or next account of the list.
4. "Exporter (CSV)" downloads the filtered list.
5. A Super-administrator can change an account's e-mail address with "Changer l'adresse e-mail", after checking the person's identity; both addresses are notified.
6. Organisation or location changes requested by an accredited accompagnateur (FR-05) are approved or refused from the account record.

**Data & Format:**
- Columns by role:
  - Entrepreneurs: Nom (+ e-mail), Projet / Organisation, Wilaya, Projets, Inscription, Statut
  - Accompagnateur·rice·s: Nom, Organisation, Wilaya, Expertise, Statut
  - Formateur·rice·s: Nom, Spécialité, Formations, Statut
  - Citoyen·ne·s: Nom, Wilaya, Contributions, Nature, Inscription, Statut
- « Informations personnelles »: Adresse e-mail, Téléphone, Identifiant de compte, Inscription (DD/MM/YYYY), Dernière connexion (DD/MM/YYYY HH:MM), the role's own fields, Adresse vérifiée (Oui / Non), Double authentification (Active / Inactive)
- Role tabs:
  - Entrepreneur: « Projets » (Projet, Rôle — Porteur·se / Équipe, Secteur, Wilaya, Dossier %, État); « Formations suivies » (Formation, Formateur·rice, Filière, État — Inscrit·e / Terminée)
  - Accompagnateur: « Capacité » (places, integer 0–50, set by administrators); « Agrément » (declaration, « Preuve fournie », « Pièces justificatives » each « Fournie » / « Manquante » with "Consulter", « Références d'accompagnement »); « Accompagnements » (Projet, Wilaya, Demande reçue, État)
  - Formateur: « Qualification » (lessons done, last test score and date); « Formations créées » (Formation, Filière, Places, État)
  - Citoyen: « Contributions » (Projet, Type, Apport, Proposé le, État)
- Recherche: text | matched on name, e-mail, organisation | 2–100 characters
- CSV export columns: Nom, E-mail, Rôle, Wilaya, Statut, Inscription
- Changer l'adresse e-mail (Super-administrator): new address (e-mail, max 254 characters, unique) and Motif (10–500 characters) | required

**Rules & Constraints:**
- Administrator accounts are not listed here (they are in FR-55); every count excludes them, on every screen (the demo counted them on the dashboard but not here).
- Access requires the scope "Utilisateurs & agréments" (FR-55).
- 25 rows per page; columns Nom and Inscription are sortable.
- Opening a supporting document and every CSV export are recorded in the history (FR-56).
- An accompagnateur's capacity cannot be set below the number of accompaniments in progress.

**Edge Cases:**
- No account matches → "Aucun compte ne correspond."
- Field not filled by the user → "Non renseigné".
- Supporting document missing from storage → "Document indisponible".
- Export of more than 5 000 rows → generated in the background; the administrator is notified with a download link valid 24 hours.

---

#### FR-54 — Account Validation Lifecycle

**Description:** An administrator can validate, refuse, suspend, reactivate and re-examine accounts, with a reason where required; the user's access changes immediately, and a refused user can contest the decision.
*Source: demo `js/sadmin-users-data.js`, `js/sadmin-users-ui.js`, `intranet/sadmin-utilisateur.html` (decision buttons); v1.0 Q&A Q73, Q76, Q113, Q129.*

**Main Flow:**
1. Administrator opens a pending account from the queue (FR-70) or from the directory filtered on « En attente de validation ».
2. Administrator reviews the information and the supporting files.
3. Administrator chooses one of the actions available for the current status; refusal and suspension ask for a reason, and before a suspension the list of the user's live items is shown.
4. System updates the status, applies the new access rights at once, e-mails and notifies the user, and records the decision (FR-56).
5. A refused user can click « Contester la décision » in the refusal e-mail and send a message; the contest reaches the queue « Contestations » (FR-70), where an administrator re-examines the account or confirms the refusal.

**Data & Format:**
- Account statuses:
  - `non_qualifie` « Qualification à passer » — Trainer who has not passed the test
  - `non_valide` « Inactif » — Accompagnateur without accreditation request, or whose request is « À revoir »
  - `en_attente` « En attente de validation » — waiting for a decision
  - `invite` « Invitation envoyée » — administrator account not yet activated (FR-55)
  - `actif` « Actif » — full access for the role
  - `suspendu` « Suspendu » — sign-in blocked
  - `refuse` « Refusé » — registration rejected, sign-in blocked
- Actions: "Valider le compte" (en_attente → actif); "Refuser" (en_attente → refuse); "Suspendre" (actif, non_qualifie or non_valide → suspendu); "Réactiver" (suspendu → status held before suspension); "Réexaminer" (refuse → en_attente); "Confirmer le refus" (after a contest)
- Motif: text | free text | required for "Refuser", "Suspendre" and "Confirmer le refus", 10–500 characters
- Message de contestation: text | free text | required, 10–1000 characters

**Rules & Constraints:**
- Entrepreneur and Citizen accounts are « Actif » from creation and need no validation.
- Accompagnateur: the account decision is the accreditation decision (FR-36) — granted → « Actif »; « À revoir » → « Inactif ». "Refuser" on the account itself is kept for fraudulent or abusive registrations.
- Formateur: « Qualification à passer » → « En attente de validation » (test passed) → « Actif » or « Refusé ». When a validated Trainer changes the CV or diplomas (FR-05), administrators are notified and can re-examine the account.
- "Réactiver" restores the status held before the suspension. "Réexaminer" always returns the account to « En attente de validation »; it is not available on administrator accounts.
- A refusal can be contested once; a refusal confirmed after a contest is final.
- Suspension ends the user's sessions immediately. Nothing else changes automatically: the administrator sees the list of the user's live items — published projects, pending offers and proposals, accompaniments, sessions with registrants — each with a direct link, and handles them case by case.

**Edge Cases:**
- Two administrators decide on the same account → the second sees "Ce compte a déjà été traité par {nom}."
- Reason under 10 characters → "Le motif doit contenir au moins 10 caractères."
- Second contest of the same refusal → the link shows "Cette décision a déjà été contestée."
- An administrator opens their own account → no decision button is shown.

---

#### FR-55 — Administrator Accounts and Scopes

**Description:** A Super-administrator can invite administrators, define the back-office sections each one can use, and suspend or reactivate them; the two Super-administrators can restore each other's access.
*Source: demo `intranet/sadmin-administrateurs.html`; TDR (« gestion des rôles et permissions »); v1.0 Q&A Q13, Q50, Q114.*

**Main Flow:**
1. Super-administrator opens "Administrateurs": tiles "Comptes d'administration", "Actifs", "Invitations en attente", "Suspendus"; the other Super-administrator account at the top; a list of administrators (Nom, Rôle, Périmètre, Dernière connexion, Statut) with search.
2. "Ajouter un administrateur" opens the form; "Envoyer l'invitation" creates the account « Invitation envoyée », e-mails an invitation without the password, and shows the provisional password once, with the button "J'ai noté le mot de passe".
3. The invitee signs in with the provisional password and the code sent by e-mail (FR-02), and sets a new password; the account becomes « Actif ».
4. The Super-administrator edits the scope, suspends or reactivates (with a reason), or re-sends an invitation.
5. If the other Super-administrator has lost access, "Rétablir l'accès" sends them a new invitation with a provisional password.

**Data & Format:**
- Nom et prénom: text | free text | required, 2–100 characters
- Adresse e-mail professionnelle: text | e-mail address | required, max 254 characters, unique across all accounts, not editable after creation
- Mot de passe provisoire: password | generated, 16 characters, with "Afficher", "Copier" and "Régénérer" | required, 12–64 characters with at least 3 of 4 character families; meter "Trop faible" / "Acceptable" / "Solide"
- Périmètre: checkboxes | "Projets & orientation", "Utilisateurs & agréments", "Formations & Académie", "Contenu de l'Extranet — rédaction", "Contenu de l'Extranet — relecture et publication", "Messagerie & annonces", "Statistiques & exports" | required, at least 1
- Motif (suspension): text | free text | required, 10–500 characters

**Rules & Constraints:**
- Only Super-administrators open this page; an Administrator receives "Accès réservé — Cette section est réservée à la super administration."
- Two Super-administrator accounts are created at installation: one for PNUD and one for the receiving national institution. The form creates Administrators only. If both Super-administrators lose access, Trybe restores one on a signed request from PNUD or the MTESS.
- The scope limits the menus, pages, queues and notifications of the administrator and is enforced on the server. The « rédaction » scope prepares content and submits it for review; the « relecture et publication » scope reviews and publishes it (FR-64).
- The invitation is valid for 72 hours from its delivery. The interface advises sending the password through a channel other than the invitation e-mail.
- Statuses: « Invitation envoyée » → « Actif » ↔ « Suspendu ».

**Edge Cases:**
- E-mail already used by any account → "Cette adresse est déjà utilisée par un compte de la plateforme."
- Invitation expired → the status reads « Invitation expirée » and "Renvoyer l'invitation" generates a new provisional password.
- Every scope unticked → "Sélectionnez au moins un périmètre."
- Administrator suspended while signed in → the session ends at the next request.
- A Super-administrator tries to restore their own access → not possible; only the other Super-administrator can.

---

#### FR-56 — Activity History

**Description:** The system records every significant action; administrators read the history of an account or a page, and Super-administrators search and export the full activity journal.
*Source: demo « Historique » tabs of `intranet/sadmin-utilisateur.html`, `intranet/sadmin-contenu.html` and `intranet/profil.html`; Super-administrator role description (« Journal d'activité »); SRS « Livrable 1 » FR-59; v1.0 Q&A Q115, Q116, Q130.*

**Main Flow:**
1. System records each action listed below with its actor, target, details, reason and date-time.
2. Administrators see the tab « Historique » of an account and of a page; "Remettre à traiter" on a request decision re-opens it, under the same conditions as "Revenir sur la décision" (FR-57, FR-61).
3. Super-administrator opens "Journal d'activité", filters by actor, action type, target type and period, and exports the result as CSV.

**Data & Format:**
- Entry: date-time DD/MM/YYYY HH:MM:SS; actor (name and role at the time); action type; target (type, identifier, label); details (before / after values, max 2000 characters); reason (max 500 characters); IP address
- Filters: Acteur (text, 2–100 characters); Type d'action (select); Type d'élément (select); Période (date range DD/MM/YYYY – DD/MM/YYYY)
- Recorded actions: sign-in success and failure; password change and reset; two-factor change; account decisions; administrator invitations and scope changes; project status changes, orientations, shortlists, publications; accreditation decisions; application, proposal and cancellation decisions; contribution decisions; training decisions, withdrawals and deletions; content publications and edits; survey status changes; announcements; edit suggestions; exports; downloads of private files (dossiers, proofs, kit)

**Rules & Constraints:**
- Entries cannot be modified or deleted through the interface.
- Technical entries — sign-ins, downloads, exports — are kept 24 months, then deleted automatically. Decisions on projects, accreditations, trainings and accounts are kept as long as the record they concern exists.
- A user sees their own history in FR-05, without IP addresses.
- Access to the journal is reserved to Super-administrators.

**Edge Cases:**
- Export of more than 5 000 entries → generated in the background, download link valid 24 hours.
- Actor account deleted later → the entry shows « Compte supprimé »; the decision itself is kept.
- No entry for the filters → "Aucune entrée pour ces critères."

---

### Module 15 — Back-office: Moderation

#### FR-57 — Project Review and Orientation

**Description:** An administrator reviews submitted projects, orients each one to a phase of the journey or refuses it, then validates its dossier, asks for additional documents, or refuses it.
*Source: demo `intranet/sadmin-projets.html`, `intranet/sadmin-projet.html`; orientation by phase in the demo panel of `js/intra-projet.js`; v1.0 Q&A Q95, Q116, Q123.*

**Main Flow:**
1. Administrator opens "Projets": tiles "Projets", "En attente de décision", "En accompagnement", "Approuvés", "Terminés"; search; status chips; table Projet, Porteur·se, Wilaya, Secteur, Phase, Statut (+ reason), Dossier %.
2. Administrator opens a project: timeline, completion bar, tabs « Informations » (Résumé, Problème adressé, Solution proposée, Besoin exprimé, « Fiche signalétique »), « Documents & démarches » ("Consulter", "Télécharger"), « Équipe », « Accompagnement » (sub-tabs « Accompagnement professionnel » and « Bénévolat & dons »).
3. Project « Soumis »: "Orienter le projet" → choose the phase → « Orienté »; or "Refuser" with a reason → « Refusé ».
4. Project « Dossier soumis »: "Valider le dossier" → « Approuvé », documents « Validé », then the shortlist (FR-58); "Demander des compléments" → choose the documents to correct and comment each → back to « Orienté »; or "Refuser" with a reason → « Refusé ».
5. Project « Refusé »: "Ré-orienter" → choose the phase → « Orienté ».
6. "Revenir sur la décision" restores the previous status while the Entrepreneur has not acted since.
7. "Exporter le dossier (PDF)" produces the snapshot of FR-57b.

**Data & Format:**
- Phase: select | "Pré-incubation", "Incubation", "Accélération", "Financement" — preset from the Entrepreneur's "Accompagnement recherché" | required to orient
- Documents à corriger: checkboxes | the deposited documents | at least 1
- Commentaire par document: text | free text | required, 10–500 characters
- Motif du refus: text | free text | required, 10–500 characters
- Recherche: text | matched on title, sector, wilaya, legal form, Entrepreneur | 2–100 characters

**Rules & Constraints:**
- Each decision changes the project in the Entrepreneur's space immediately and notifies the Entrepreneur and the team.
- The list menu and the record produce the same result: "Accepter" on a « Soumis » project opens the phase choice; on a « Dossier soumis » project it validates the dossier.
- A request for additional documents is not a refusal and is not counted as one in the statistics (FR-71).
- When a project is refused or re-oriented, its accepted accompaniments end automatically (FR-40): places freed, dossier access removed, conversations read-only; both parties are notified.
- "Revenir sur la décision" — and « Remettre à traiter » from the history (FR-56) — are available only while the Entrepreneur has not acted since the decision (document uploaded, resubmission).
- Access requires the scope "Projets & orientation".

**Edge Cases:**
- Two administrators decide at the same time → the second sees "Ce projet a déjà été traité par {nom}."
- Entrepreneur edits the project during the review → banner "Modifié par le·la porteur·se à HH:MM — rechargez avant de décider."
- Document that cannot be shown in the browser (DOCX, XLSX) → "Télécharger" only.
- Entrepreneur account suspended → decisions remain possible; notifications are delivered on reactivation.

---

#### FR-57a — Phase Completion and Next Phase

**Description:** An administrator confirms that a project has completed its phase and opens the next phase, or closes the project as « Terminé ».
*Source: v1.0 Q&A Q121 (not in the demo).*

**Main Flow:**
1. A project enters the queue « Phases à confirmer » when its accompagnateur closes the accompaniment with the outcome « Phase terminée » (FR-40a); an administrator can also open the action from any « Approuvé » project.
2. Administrator reads the closing summary and chooses:
   - "Ouvrir la phase suivante" → the next phase is preselected (Pré-incubation → Incubation → Accélération → Financement); the project returns to « Orienté » with the documents required for that phase (FR-34);
   - "Clôturer le projet" → the project becomes « Terminé »;
   - "Refuser" with a reason → the project stays « Approuvé » and the accompagnateur is notified.
3. The Entrepreneur and the team are notified; the timeline (FR-33) shows the new phase or « Terminé ».

**Data & Format:**
- Phase suivante: select | the 4 phases | required to open a phase; default the next one
- Motif (refusal): text | free text | required, 10–500 characters
- Commentaire pour le·la porteur·se: text | free text | optional, max 1000 characters

**Rules & Constraints:**
- After « Financement », only "Clôturer le projet" is possible.
- Opening the next phase keeps the project published (FR-60) and keeps the documents of earlier phases under « Phases précédentes ».
- A « Terminé » project is read-only; it can stay published and no longer counts in « Projets actifs » (FR-31).
- Access requires the scope "Projets & orientation".

**Edge Cases:**
- Project withdrawn before the decision → it leaves the queue.
- Two administrators decide at the same time → the second sees "Ce projet a déjà été traité par {nom}."
- Project approved but never accompanied → the administrator can open the next phase or close the project directly from its record.

---

#### FR-57b — PDF Export of a Project Dossier

**Description:** An administrator can export a project's dossier as a dated PDF snapshot for committees and funders.
*Source: Note de cadrage (export « dossier projet » en PDF); v1.0 Q&A Q49 (not in the demo).*

**Main Flow:**
1. On a project record, the administrator clicks "Exporter le dossier (PDF)".
2. System builds the PDF in the background (Section 5.1) and notifies the administrator when it is ready.
3. Administrator downloads the PDF from the notification or the record; the export is recorded in the history (FR-56).

**Data & Format:**
- PDF content: cover (project title, Entrepreneur, sector, wilaya, legal form, phase, status, export date and author); project information (summary, problem, solution, beneficiaries, needs); team (names and roles); status history with dates and decisions; list of dossier documents (name, phase, date, state); accompaniments (accompagnateur, dates, outcome)
- File name: `Dossier-{titre}-{AAAAMMJJ}.pdf`
- Language: the administrator's interface language

**Rules & Constraints:**
- Every page carries the mention "Document confidentiel — exporté le DD/MM/YYYY par {nom}".
- The PDF contains no e-mail address or phone number and does not embed the documents themselves.
- Access requires the scope "Projets & orientation".

**Edge Cases:**
- Project without documents → the documents section reads "Aucun document déposé."
- Very long texts → they continue on the following pages; nothing is cut.
- Export fails → the administrator is notified "L'export n'a pas pu être généré. Réessayez." and nothing is recorded.

---

#### FR-58 — Accompagnateur Shortlist

**Description:** After approving a dossier, an administrator selects the accredited accompagnateurs the Entrepreneur may apply to, and widens the selection on request.
*Source: demo panel « Mode démo — action de l'administration » in `js/intra-projet.js` (« Rediriger vers ces accompagnateur·rice·s ») and the Entrepreneur's « Demander d'élargir la sélection »; no back-office screen in the demo.*

**Main Flow:**
1. On an « Approuvé » project, the administrator opens « Accompagnement » → « Sélection d'accompagnateur·rice·s »: accredited accompagnateurs whose accreditation covers the project's phase, with organisation, wilaya, expertise and places left.
2. Administrator ticks one or more, optionally adds a note, and clicks "Rediriger vers ces accompagnateur·rice·s".
3. The Entrepreneur is notified and receives the task "Choisir un·e accompagnateur·rice" (FR-37).
4. A widening request appears in the queue « Demandes d'élargissement » (FR-70); the administrator adds accompagnateurs the same way and the Entrepreneur is notified.

**Data & Format:**
- Sélection: checkboxes | accredited accompagnateurs | required, 1–10
- "Afficher tous les profils agréés": toggle | includes accompagnateurs whose accreditation does not cover the phase | default off
- Note pour le·la porteur·se: text | free text | optional, max 500 characters

**Rules & Constraints:**
- Only accredited accompagnateurs with at least 1 place left can be ticked; others are shown disabled with "Complet". Capacity is set on the account record (FR-53).
- The shortlist can be extended later; an accompagnateur with a pending or accepted relation on the project cannot be removed from it.
- Access requires the scope "Projets & orientation".

**Edge Cases:**
- No accredited accompagnateur for the phase → every accredited profile is shown with "Aucun·e accompagnateur·rice agréé·e pour cette phase — tous les profils sont affichés."
- No accredited accompagnateur at all → "Aucun·e accompagnateur·rice agréé·e disponible."; the project stays in the queue « Sélections à préparer ».
- A shortlisted accompagnateur is suspended → the Entrepreneur sees "Indisponible" (FR-37) and the project returns to the queue for a replacement.

---

#### FR-58a — Common Application Questionnaire

**Description:** Administrators define a common set of questions every Entrepreneur answers when applying to an accompagnateur.
*Source: v1.0 Q&A Q34 (not in the demo).*

**Main Flow:**
1. Administrator opens "Projets" → "Questionnaire de candidature".
2. Administrator adds, edits, reorders or removes questions, in French and Arabic, and saves.
3. From then on, the application modal (FR-37) shows these questions first, followed by the accompagnateur's own questions (FR-36).

**Data & Format:**
- Question: text | FR and AR | required, max 150 characters
- Type de réponse: select | "Texte libre", "Choix" | required
- Options ("Choix"): 2–5 options | max 40 characters each
- Obligatoire: boolean | default yes
- Number of questions: 0–5

**Rules & Constraints:**
- Changes apply to applications started afterwards; applications already sent keep the questions as asked (FR-37).
- The questionnaire requires the scope "Projets & orientation"; every change is recorded (FR-56).

**Edge Cases:**
- A question is removed while Entrepreneurs are answering → their send is refused with "Le questionnaire a changé, veuillez le relire" (FR-37).
- "Choix" question with fewer than 2 options → "Ajoutez au moins deux options."
- No common question and no accompagnateur question → the modal shows only the optional message.

---

#### FR-59 — Edit Suggestions

**Description:** An administrator can suggest a correction to a project or to an accompagnateur's profile; the owner accepts or refuses it.
*Source: meeting notes of 23 September (suggestions de modification par l'administrateur, notifiées et soumises à acceptation); not built in the demo; v1.0 Q&A Q12.*

**Main Flow:**
1. On a project record or an accompagnateur record, the administrator clicks "Suggérer une modification", chooses a field, enters the proposed value and an explanation, and sends.
2. The owner — the project's Entrepreneur or the Accompagnateur — is notified and sees the current and proposed values side by side.
3. Owner clicks "Accepter" (the value is applied) or "Refuser" (optional comment).
4. The administrator is notified of the answer and the suggestion is closed.

**Data & Format:**
- Champ: select | project: title, summary, problem, solution, beneficiaries, sector, wilaya, legal form, visual, needs; accompagnateur: fonction, organisation, zone, expertise, presentation | required
- Valeur proposée: same type, format and constraints as the chosen field | required
- Explication: text | free text | required, 10–500 characters
- Commentaire (refusal): text | free text | optional, max 500 characters

**Rules & Constraints:**
- Suggestions also apply to « Approuvé » projects; they are the only way to change a locked project (FR-33).
- One pending suggestion per field and target.
- A suggestion unanswered for 30 days becomes « Expirée » and the administrator is notified.
- An accepted value is recorded with its before and after values (FR-56).

**Edge Cases:**
- Owner changes the field before answering (project not locked) → the suggestion becomes « Obsolète » automatically.
- Target refused, deleted or suspended → the suggestion is cancelled.
- Proposed value invalid → the same validation messages as the field's own form.

---

#### FR-60 — Choosing Which Projects Go Public

**Description:** An administrator decides which projects appear on the public portal, writes their public presentation, and can add showcase projects that have no platform account.
*Source: demo content tree « Projets & initiatives » in `intranet/sadmin-contenu.html` (« Publier » / « Dépublier »); UGP feedback V0, « Section 7 — Référencez votre projet »; FR-12, FR-14; v1.0 Q&A Q3, Q4, Q85, Q117, Q124, Q125.*

**Main Flow:**
1. Administrator opens "Contenu de l'extranet" → "Projets & initiatives": approved and completed projects, and showcase projects.
2. Administrator writes the public presentation, previews it and clicks "Publier".
3. Administrator can "Dépublier", and set « À l'affiche » with its display month and order (FR-14).
4. "Ajouter un projet vitrine" creates a public project not linked to an account — for example a programme project — with the same fields plus title, summary, problem, solution, beneficiaries, sector, wilaya, legal form and visual (constraints of FR-32); the loading of programme projects is pending the client's answer (Q9).

**Data & Format:**
- Stade d'avancement public: select | "Idéation", "Conception", "Financement", "Développement" (Q1, Q2) | required to publish
- Besoins: the project's single « Besoins » field (FR-32), editable here | optional
- Période: text | "AAAA – AAAA" | optional
- Budget: number | integer, DZD | optional
- Zone d'intervention: text | free text | optional, max 150 characters
- Rôle de l'ESS, Impacts, Partenaires & appui: text | free text | optional, max 1000 characters each
- Vidéo: URL | YouTube or Vimeo | optional
- Statut public: « Publié » / « Non publié »

**Rules & Constraints:**
- A project linked to an account can be published once it is « Approuvé » or « Terminé »; the Entrepreneur's consent is covered by the terms of use accepted at registration.
- Public texts are written by administrators and published without the Entrepreneur's review; the Entrepreneur is notified when the project is published or unpublished.
- Dossier documents are never published.
- Showcase projects show no « Contacter le porteur », do not appear in the volunteering and mentoring lists (FR-22, FR-23), and cannot receive offers.
- Unpublishing takes effect everywhere at once: catalogue, homepage, search, structure pages and Participation lists.
- Access requires the scope "Projets & orientation" or "Contenu de l'Extranet — relecture et publication".

**Edge Cases:**
- Project refused or withdrawn → unpublished automatically; a project moving to its next phase (FR-57a) stays published.
- "Publier" without a public stage → "Indiquez le stade d'avancement public."
- Showcase project without a visual → the default sector illustration (FR-12).
- Offer form opened on a showcase project through a direct link → "Ce projet ne reçoit pas de propositions en ligne."

---

#### FR-61 — Training Moderation

**Description:** An administrator validates or refuses submitted trainings, withdraws or republishes published ones, and decides on deletion requests.
*Source: demo `intranet/sadmin-formations.html`, `intranet/sadmin-formation.html`; v1.0 Q&A Q66, Q87, Q109.*

**Main Flow:**
1. Administrator opens "Formations": tiles "Formations", "À confirmer", "Publiées", "Retirées"; search; Filière; status chips "Toutes", "À confirmer", "Publiée", "Refusée", "Retirée"; table Formation, Formateur·rice (link to the account), Filière, Format (+ duration), Niveau, Statut (+ reason).
2. Administrator opens a training: « Informations », « Objectifs pédagogiques » (warning if empty), modules or lessons with a reader (warning if none), « Quiz de validation »; in-person trainings show the session details.
3. Training « À confirmer »: "Accepter et publier" → « Publiée » in every catalogue; or "Refuser avec motif" → « Refusée » (the Trainer sees « À revoir »).
4. Training « Publiée »: "Retirer" with a reason → « Retirée », hidden from every catalogue, registrants notified. Training « Retirée »: "Publier" → « Publiée ».
5. Deletion request: "Accepter et supprimer" (irreversible, confirmation) or "Refuser la suppression" with a reason.

**Data & Format:**
- Motif (refusal, withdrawal, refusal of deletion): text | free text | required, 10–500 characters
- Recherche: text | matched on title and Trainer | 2–100 characters
- Filière: select | "Toutes les filières (n)" + filière list

**Rules & Constraints:**
- Administrator statuses map to the Trainer's: « À confirmer » = « En validation »; « Publiée » = « Validée »; « Refusée » = « À revoir »; « Retirée » has no Trainer equivalent and shows « Retirée ».
- Trainer-authored trainings and their deletion requests appear in this list and in the queues of FR-70. (In the demo they were reachable only by direct link.)
- A withdrawn training disappears from the public and learner catalogues. (The demo kept it visible.)
- Reviewing changes to a published training (FR-48) shows the changed fields side by side with the published values.
- Approving a change to a session's date, time, place or joining link e-mails that session's registrants (FR-48); withdrawing a training cancels its upcoming sessions (FR-48a).
- "Revenir sur la décision" is available while no learner has registered since the decision.
- Access requires the scope "Formations & Académie".

**Edge Cases:**
- Withdrawing a training with registrants → each registrant receives "La formation {titre} a été retirée du catalogue."
- Trainer suspended → their published trainings stay online unless withdrawn; the training list shows the tag "Formateur·rice suspendu·e".
- Deleting a training with past sessions → aggregated statistics keep their counts.

---

#### FR-61a — Trainings Created by Administrators

**Description:** An administrator can create a catalogue training directly, with the same content as a Trainer's training, and publish it without the validation step.
*Source: v1.0 Q&A Q9 (« formations : catalogue prédéfini », meeting notes of 23 September) — not in the demo.*

**Main Flow:**
1. Administrator opens "Formations" → "Créer une formation".
2. Administrator completes the same steps as FR-48 and chooses who runs it: an active Trainer account or « Équipe du programme ».
3. "Publier" publishes the training directly in the catalogue (FR-18); the assigned Trainer is notified and sees its sessions in their agenda (FR-49).

**Data & Format:**
- All fields of FR-48, with the same formats and constraints
- Animé par: select | active Trainer accounts + « Équipe du programme » | required

**Rules & Constraints:**
- Administrator-created trainings skip the « En validation » step; later changes are made by administrators only.
- Sessions are added and cancelled as in FR-48a.
- Access requires the scope "Formations & Académie".

**Edge Cases:**
- Assigned Trainer suspended → the training stays published, showing « Équipe du programme » until an administrator reassigns it.
- In-person training published without an upcoming session → it is not listed in the catalogue until a session is added.
- Two administrators edit the same training → the second save shows "Cette formation a été modifiée par {nom} à HH:MM."

---

#### FR-62 — Qualification and Kit Set-up

**Description:** An administrator builds the trainers' qualification course and test, sets the pass mark, and distributes the pedagogical kit.
*Source: demo `intranet/sadmin-qualification.html`, `intranet/sadmin-qualif-formation.html`, `intranet/sadmin-qualif-test.html`, `intranet/sadmin-kit.html`.*

**Main Flow:**
1. "Devenir formateur" → "Parcours" shows two cards: « Formation de qualification du formateur » (Étape 1 — « Aucune leçon », « À compléter » or « Configuré », button "Gérer les leçons") and « Test de qualification du formateur » (Étape 2 — « Aucune question » or « Prêt », "N / 6 exigées", button "Voir les questions").
2. Lessons: "Ajouter" opens the lesson form; "Enregistrer la leçon" saves; "Supprimer la leçon ?" deletes after confirmation; lessons can be reordered.
3. Test: list of questions, "Ajouter une question", edit, delete, "Vider le test" (confirmation), and the « Seuil de réussite » with "Enregistrer".
4. Kit: documents with « Distribué » / « Retiré » and the related lesson; "Ajouter un kit"; "Consulter"; "Modifier" and "Supprimer"; "Retirer" / "Redistribuer".

**Data & Format:**
- Titre de la leçon: text | free text | required, max 120 characters
- Durée: text | e.g. "15 min" | optional, max 20 characters
- Vidéo de la leçon: MP4 or MOV file max 500 MB, or YouTube / Vimeo URL | required for the lesson to count as complete
- Description: text | free text | required for completeness, max 3000 characters
- Supports: files | PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, max 20 MB each | optional, 0–10
- Question — Type: select | "Choix multiple", "Réponse à saisir" | required
- Question — Énoncé: text | required, max 300 characters
- Choix multiple: 2–6 options, max 150 characters each, each with a "Bonne" checkbox | at least 1 correct and at least 1 incorrect
- Réponse à saisir — Réponses acceptées: text | one accepted answer per line | required, 1–10 lines, max 100 characters each
- Seuil de réussite: number | integer 1–100, step 5 | required, default 60
- Kit — Fichier: file | PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX (max 20 MB), MP4, MOV (max 500 MB) | required
- Kit — Titre: text | prefilled from the file name | required, max 120 characters
- Kit — Description: text | optional, max 500 characters
- Kit — Leçon rattachée: select | the qualification lessons | optional

**Rules & Constraints:**
- A lesson is complete when it has a video and a description; the course is « Configuré » when it has at least 1 lesson and every lesson is complete.
- The test is « Prêt » with at least 6 valid questions; below that, Trainers see "Le test n'est pas encore disponible." (FR-46).
- Typed answers are compared ignoring case and accents; scoring is all-or-nothing per question.
- Changes apply to attempts started afterwards.
- "Retirer" hides a kit document from Trainers at once; "Redistribuer" shows it again and notifies validated Trainers.
- Access requires the scope "Formations & Académie".

**Edge Cases:**
- Lesson deleted while Trainers are following the course → their progress on that lesson is discarded; the remaining lessons decide when the test unlocks.
- "Vider le test" while a Trainer is taking it → the attempt in progress is scored on the questions already drawn.
- Every option marked "Bonne" → "Au moins une proposition doit être incorrecte."
- Pass mark outside 1–100 → "Le seuil doit être compris entre 1 et 100 %."

---

#### FR-63 — Contributions Oversight

**Description:** An administrator can follow every citizen contribution offer and its outcome, without deciding in the Entrepreneur's place.
*Source: demo `intranet/sadmin-benevolat.html`; tab « Bénévolat & dons » of `intranet/sadmin-projet.html`.*

**Main Flow:**
1. Administrator opens "Bénévolat & contributions": list of offers — Citoyen·ne, Projet, Type, Apport (skills, expertise or amount), Proposé le, Statut.
2. Administrator filters by type, status and project, and opens an offer: author, project, details, date, message, refusal reason.
3. Administrator can contact the Citizen or the Entrepreneur (FR-50).

**Data & Format:**
- Type: select | "Tous", "Bénévolat", "Mentorat", "Promesse de don" | default "Tous"
- Statut: select | "Tous", "En attente d'acceptation", "Acceptée", "Terminée", "Refusée" | default "Tous"
- Projet: text | matched on project title | optional, 2–100 characters

**Rules & Constraints:**
- The screen is read-only, with the banner "Lecture seule — la décision revient au·à la porteur·se du projet."
- Donation pledges, if kept (Q4), are counted in statistics as pledges, labelled as not collected (FR-71).
- Access requires the scope "Projets & orientation".

**Edge Cases:**
- No offer → "Aucune contribution pour le moment."
- Offer on an unpublished project → listed with the tag "Projet non publié".
- Citizen account suspended → the offer is listed with the tag "Compte suspendu".

---

### Module 16 — Back-office: Content Editing & Settings

#### FR-64 — Page Editor

**Description:** An administrator can edit the text and images of every public page in French and Arabic and submit the changes for review; a reviewer publishes them; each page keeps its change history.
*Source: demo `intranet/sadmin-contenu.html` (content tree, page editor, « Réglages », « Historique »), `js/sadmin-content-data.js` (block types); Note de cadrage (brouillon → en relecture → publié); v1.0 Q&A Q50, Q56, Q118.*

**Main Flow:**
1. Administrator opens "Contenu de l'extranet" → "Pages & rubriques": the tree « Pages du site » (Accueil, Découvrir l'ESS, Accompagnement & financement, Académie, Participation, Ressources, Médias, Contact, Mentions légales, Confidentialité, Accessibilité), « Contenus du programme » and « Communication ».
2. Administrator opens a page; tab « Contenu » lists its blocks in their fixed order; the switch "FR / AR" changes the editing language and the indicator "AR x %" shows translation completeness.
3. An editor (scope « Contenu de l'Extranet — rédaction ») edits block fields — rows of list blocks (key figures, steps, FAQ entries) can be added or removed — and clicks "Soumettre à relecture".
4. A reviewer (scope « Contenu de l'Extranet — relecture et publication ») opens « Contenus à relire » (FR-70), checks the changes with "Aperçu", and clicks "Publier", or "Renvoyer en rédaction" with a comment.
5. Tab « Réglages »: Nom de la page, Segment d'URL, Libellé de navigation, Statut de publication.
6. The publish bar shows "Brouillon", "En relecture", "Publié — à jour" or "Modifications en relecture", with "Aperçu" and "Voir la page publiée".
7. Tab « Historique » lists each change with its type, before and after values, author and time, and each review decision.

**Data & Format:**
- Block types: Hero (Sur-titre, Titre, Chapô, Image de fond, Bouton principal, Bouton secondaire); Texte riche (Sur-titre, Titre, Chapô, Corps du texte); Média + texte (Sur-titre, Titre, Chapô, Corps du texte, Image); Chiffres clés (Sur-titre, Titre, figures of FR-11); Étapes du parcours (Sur-titre, Titre, Chapô, steps with Titre de l'étape and Description); Collection (Sur-titre, Titre, Collection affichée — "Projets & initiatives", "Actualités", "Événements", "Ressources", "Académie ESS" — and Nombre d'éléments affichés); Citation éditoriale (Étiquette, Citation, Texte d'accompagnement, Nom, Fonction, Photo); FAQ (Titre, Chapô, questions with Question and Réponse); Carte + repères (Sur-titre, Titre, Légende, Image de la carte, Wilayas couvertes — homepage map only, FR-07); Bandeau d'appel à l'action (Titre, Texte, Bouton, Lien)
- Sur-titre: text | max 60 characters
- Titre: text | max 120 characters (Hero: max 60, FR-07)
- Chapô: text | max 300 characters
- Corps du texte: rich text | bold, italic, links, bulleted and numbered lists, sub-headings | max 10 000 characters
- Image: JPG, PNG, WebP, max 5 MB, with Texte alternatif | alternative text required, max 150 characters
- Bouton: label max 30 characters + link to an internal page or an https:// URL
- Nombre d'éléments affichés: integer | 1–24
- Nom de la page: text | required, max 80 characters
- Segment d'URL: text | lowercase letters, digits and hyphens | required, 3–60 characters, unique
- Libellé de navigation: text | optional, max 30 characters
- Statut de publication: « Brouillon » / « En relecture » / « Publié »
- Commentaire de relecture: text | free text | required when sending back, 10–500 characters

**Rules & Constraints:**
- Each page has a fixed set and order of blocks; blocks cannot be added, removed or reordered. This keeps the order set by the UGP (FR-07, FR-15).
- Every public page is editable.
- Workflow: « Brouillon » → « En relecture » → « Publié ». Editors cannot publish; reviewers can correct a page before publishing it. Changes to a published page stay invisible to visitors until a reviewer publishes them.
- A page can be published with Arabic incomplete; missing Arabic fields display the French text with the notice of FR-06.
- While a page of the main menu is unpublished, its menu item is hidden (FR-06).
- Changing the URL segment redirects the former address permanently (HTTP 301) to the new one.
- Access requires one of the two « Contenu de l'Extranet » scopes.

**Edge Cases:**
- Two administrators edit the same page → the second save shows "Cette page a été modifiée par {nom} à HH:MM. Rechargez pour voir ses modifications." and nothing is overwritten.
- An editor changes a page that is « En relecture » → it returns to « Brouillon » and the reviewer is notified.
- Image without alternative text, or required field empty → submission for review is blocked and the missing fields are listed.
- URL segment already used → "Ce segment d'URL est déjà utilisé."
- Administrator leaves with unsaved changes → confirmation "Quitter sans enregistrer ?".

---

#### FR-65 — News and Events

**Description:** An administrator can create, edit, schedule, publish, unpublish and delete news items and events, and follow event registrations.
*Source: demo `intranet/sadmin-contenu.html` (collections « Actualités » and « Événements »); UGP feedback V0 (merge of agenda and news, FR-26); v1.0 Q&A Q50, Q92, Q119.*

**Main Flow:**
1. Administrator opens "Communication" → "Actualités" or "Événements": list with title, date, status, "Publier" / "Dépublier".
2. "Ajouter" opens the form; "Enregistrer le brouillon" or "Soumettre à relecture"; a reviewer then clicks "Publier" or "Programmer", or sends the item back with a comment (FR-64).
3. Administrator edits or deletes an existing item. (The demo allowed neither.)
4. On an event, tab « Inscriptions » lists registrants (Nom, E-mail, Organisation, Date d'inscription) with "Exporter (CSV)" and "Annuler l'événement".

**Data & Format:**
- Actualité — Titre: text | required, 5–150 characters
- Actualité — Catégorie: select | "Programme", "Analyse", "Événement", "Politique", "Terrain", "International", "Financement", "Institutionnel", "Accompagnement" | required
- Actualité — Portée: select | "Algérie", "Monde" | required
- Actualité — Date de publication: date-time | DD/MM/YYYY HH:MM, now or later | required
- Actualité — Résumé: text | required, 30–300 characters
- Actualité — Corps: rich text | required, max 20 000 characters
- Actualité — Image: JPG, PNG, WebP, max 5 MB | optional; when present, Texte alternatif (max 150) and Crédit (max 100) required
- Événement — Titre: text | required, 5–150 characters
- Événement — Date / Heure de début / Heure de fin: DD/MM/YYYY, HH:MM | date and start time required; end time optional, after start
- Événement — Format: select | "Présentiel", "En ligne" | required
- Événement — Lieu: text | max 200 characters | required for "Présentiel"
- Événement — Lien de connexion: URL | https://… | required for "En ligne"
- Événement — Organisateur: text | required, max 150 characters
- Événement — Description: rich text | required, max 5000 characters
- Événement — Inscription requise: yes / no | default yes
- Événement — Capacité: integer | 1–5000 | optional (empty = unlimited)
- Événement — Pièces jointes: PDF | max 10 MB each | 0–3
- Every text field has a French and an Arabic version

**Rules & Constraints:**
- New items start as « Brouillon » and follow the review workflow of FR-64; "Publier" is immediate; "Programmer" publishes at the chosen date-time.
- A cancelled event stays visible with the tag « Annulé » and no "Participer" button until its date, then leaves the site.
- An event with registrants cannot be deleted; it must first be cancelled with "Annuler l'événement", which e-mails its registrants.
- Changing the date, time or place of an event with registrants e-mails them automatically.
- Capacity cannot be set below the number of registrants.
- Access requires the scope "Contenu de l'Extranet".

**Edge Cases:**
- "Programmer" with a past date-time → "La date de publication doit être dans le futur."
- End time before start time → "L'heure de fin doit être postérieure à l'heure de début."
- Image without credit → "Indiquez le crédit de l'image."
- Online event without a joining link → publication blocked with "Ajoutez le lien de connexion."

---

#### FR-66 — Resources and Replays

**Description:** An administrator can add, edit, version, publish, withdraw and delete the documents of the resource centre and the webinar replays.
*Source: demo `intranet/sadmin-support.html`, `intranet/sadmin-replay.html`; download statistics promised by `intranet/sadmin-contenu-ressources.html`; v1.0 Q&A Q14, Q50, Q90.*

**Main Flow:**
1. Administrator opens "Ressources & supports": tabs « Documents » and « Replays », button "Ajouter ▾" → "Ajouter un document" / "Ajouter un replay".
2. Documents list: filters Type de contenu, Thème, Langue, Format and "Réinitialiser les filtres"; columns Titre, Type de contenu, Thème, Langue, Format, Publié le, Téléchargements; actions "Modifier", "Retirer de la publication" / "Remettre en ligne", "Supprimer".
3. The document form ends with "Enregistrer le brouillon" or "Soumettre à relecture" (a reviewer publishes, FR-64); "Remplacer le fichier" keeps the previous files under « Versions ».
4. Replays list: Webinaire, Intervenant·e, Thème, Durée, Publié le; actions "Modifier", "Retirer" / "Remettre en ligne", "Ouvrir la vidéo".

**Data & Format:**
- Document — Titre: text | required, 5–150 characters (FR and AR)
- Document — Description: text | required, max 500 characters (FR and AR)
- Document — Fichier: file | PDF, DOCX, XLSX | required, max 20 MB
- Document — Type de contenu: select | "Guide", "Texte de loi", "Étude", "Boîte à outils" | required
- Document — Thème: select | sector list | required
- Document — Langue: select | "FR", "AR", "FR / AR" | required
- Document — Format: detected from the file | read-only
- Replay — Titre du webinaire: text | required, 5–150 characters
- Replay — Intervenant·e: text | suggestions from Académie trainers, free text allowed | required, max 100 characters
- Replay — Lien de la vidéo (YouTube or Vimeo URL) or Fichier vidéo (MP4, max 500 MB) | exactly one required
- Replay — Thème: select | replay themes (FR-69b) | required
- Replay — Durée: text | "X min" | required
- Replay — Date et heure de diffusion: DD/MM/YYYY HH:MM | required
- Replay — Vignette: image upload | JPG, PNG, WebP, max 5 MB | optional
- Replay — Description: text | optional, max 1000 characters

**Rules & Constraints:**
- Documents and replays follow the same « Brouillon » → « En relecture » → « Publié » workflow as other content (FR-64). (In the demo they went online immediately.)
- Replacing a file keeps the previous versions (date, size, author) visible to administrators; the public always downloads the current version.
- Each document shows its download count (FR-24).
- "Retirer de la publication" hides an item and "Remettre en ligne" republishes it. (The demo promised republication but offered no way to do it.)
- Access requires the scope "Contenu de l'Extranet".

**Edge Cases:**
- File content not matching its extension → "Le contenu du fichier ne correspond pas à son format."
- Replay with both a link and a file → "Indiquez un lien ou un fichier, pas les deux."
- Deleting a document linked from a page → a warning lists the pages that link to it before confirmation.

---

#### FR-67 — Surveys and Results

**Description:** An administrator can create surveys, write their questions, schedule, open and close them, and analyse and publish their results.
*Source: demo `intranet/sadmin-sondages.html` (list, creation form, detail, question editor, results); v1.0 Q&A Q43, Q44, Q50, Q127, Q128.*

**Main Flow:**
1. Administrator opens "Sondages": tiles "Sondages", "Ouverts", "Questions écrites", "Résultats publiés"; status chips; table Sondage, Thème, Statut, Questions, Collecte, Échéance, "Ouvrir".
2. "Créer un sondage" opens the form; the survey is created as « Brouillon ».
3. On the survey page, the administrator edits the information in place ("Modifier" / "Enregistrer" / "Annuler"), adds, edits, reorders (drag and drop or arrow keys) and deletes questions, and checks the preview « Ce que voit le·la répondant·e ».
4. Status actions: "Programmer" (→ « À venir », opens automatically at the opening date), "Ouvrir maintenant" (→ « Ouvert »), "Clôturer" (→ « Clos »), "Publier les résultats" (→ « Résultats publiés »), "Dépublier — repasser en brouillon", "Supprimer le sondage".
5. Results (« Clos » or « Résultats publiés »): complete responses, completion rate, questions asked, closing date; per question a chart (sorted bars for choices, distribution and mean for scales) or the list of text answers; "Exporter (CSV)".

**Data & Format:**
- Titre: text | required, 5–150 characters (FR and AR)
- Présentation: text | optional, max 1000 characters (FR and AR)
- Thème: select | survey themes (FR-69b) | required
- Date d'ouverture: date-time | DD/MM/YYYY HH:MM | required
- Échéance: date-time | DD/MM/YYYY HH:MM, after the opening date | required
- Quota de réponses: integer | 0–100 000, "0 = illimité" | required, default 0
- Collecte: radio | "Anonyme" (« Aucune donnée personnelle collectée… »), "Nominatif" (« …notice de consentement affichée ») | required
- Question — Type: select | "Choix multiple", "Échelle", "Champ texte" | required
- Question — Énoncé: text | required, max 300 characters
- Choix multiple — options: 2–10, max 150 characters each
- Échelle — Graduation: select | "1 à 3", "1 à 4", "1 à 5", "1 à 7", "1 à 10"; optional labels for the two ends, max 40 characters

**Rules & Constraints:**
- The lifecycle is enforced: « Brouillon » → « À venir » → « Ouvert » → « Clos » → « Résultats publiés »; the system opens and closes surveys automatically at their dates or when the quota is reached. (In the demo the status was a free drop-down.)
- A survey cannot leave « Brouillon » with no question or with an incomplete question (« Sans énoncé », « Moins de deux propositions »).
- Questions are locked as soon as the first response is received. "Dépublier" and "Supprimer" are available only while the survey has no response.
- Text answers are visible to administrators only and never published; for nominative surveys, the author's name is shown to administrators.
- A survey appears on the public Participation page from « À venir » onward. (Surveys created in the demo back-office never reached the public list.)
- Results are computed from the responses received.
- "Publier les résultats" is refused for a survey without any response ("Aucune réponse : les résultats ne peuvent pas être publiés."); a rate that cannot be computed is shown as « — ».
- The actions that make a survey public — "Programmer", "Ouvrir maintenant", "Publier les résultats" — are reserved to reviewers (scope « Contenu de l'Extranet — relecture et publication »); editors prepare drafts.
- Access requires the scope "Contenu de l'Extranet".

**Edge Cases:**
- Quota reached → the survey closes automatically and the administrators in scope are notified.
- "Programmer" when the closing date is already past → "L'échéance est déjà passée."
- Export with no response → "Aucune réponse à exporter."
- Nominative respondent's account deleted → the answers are kept with the author "Compte supprimé".

---

#### FR-68 — Media Library

**Description:** An administrator can publish photo albums and videos, credit each photo, and choose the photos of « L'ESS en images ».
*Source: demo content tree « Médias & communication » (not connected: « Aucun élément à gérer pour l'instant »); UGP feedback V0, « Médias ».*

**Main Flow:**
1. Administrator opens "Communication" → "Médias & communication": albums and videos with their status.
2. "Créer un album": title, date, description; upload several photos at once, each with caption, credit and alternative text; reorder by drag and drop; choose the cover.
3. "Ajouter une vidéo": title, URL, description.
4. "Choisir les photos de « L'ESS en images »" selects photos from the albums for the mosaic.
5. "Publier" / "Dépublier"; "Supprimer" after confirmation.

**Data & Format:**
- Album — Titre: text | required, 5–150 characters
- Album — Date: date | DD/MM/YYYY | required
- Album — Description: text | optional, max 1000 characters
- Album — Couverture: one of the album's photos | required
- Photo: JPG, PNG, WebP | max 10 MB each, max 100 per album
- Photo — Légende: text | optional, max 200 characters
- Photo — Crédit: text | required, max 100 characters
- Photo — Texte alternatif: text | required, max 150 characters
- Vidéo — Titre: text | required, max 150 characters
- Vidéo — URL: YouTube or Vimeo | required
- Vidéo — Description: text | optional, max 500 characters
- « L'ESS en images »: selection | 1–12 photos

**Rules & Constraints:**
- Photos are resized for display (max 2000 px on the longest side) and originals are kept.
- Every photo needs a credit before its album can be published (Note de cadrage: image credits and copyright).
- Albums and videos follow the « Brouillon » → « En relecture » → « Publié » workflow (FR-64).
- Access requires the scope "Contenu de l'Extranet".

**Edge Cases:**
- Some uploads fail → the successful photos are kept and the failed ones are listed with "Réessayer".
- Photos without credit → publication blocked with "N photo(s) sans crédit."
- A photo used in « L'ESS en images » is deleted → it leaves the mosaic.

---

#### FR-69a — Support Structures and Financing Sources

**Description:** An administrator can maintain the directory of support structures and the panorama of financing sources shown on the public portal.
*Source: demo fixed data in `js/data.js` (8 structures, 8 financing schemes; no back-office screen); UGP feedback V0 typologies (« Bandeau 3 », « Bandeau 5 »); FR-10, FR-16, FR-17; v1.0 Q&A Q64, Q82.*

**Main Flow:**
1. Administrator opens "Contenus du programme" → "Accompagnement & financement": tabs « Structures » and « Sources de financement ».
2. "Ajouter une structure" or "Ajouter une source" opens the form; "Enregistrer le brouillon" or "Publier".
3. Administrator edits, unpublishes or deletes an entry.

**Data & Format:**
- Structure — Nom: text | required, 2–150 characters
- Structure — Catégorie: select | "Institutions ou dispositifs", "Pré-incubateur", "Incubateur", "Accélérateur", "Réseau ESS" | required
- Structure — Catégorie « Où trouver un appui »: select | the support categories of FR-10 | optional
- Structure — Zone: select | wilaya list + "National" | required
- Structure — Thématique: text | required, max 80 characters
- Structure — Description: text | required, 30–1000 characters (FR and AR)
- Structure — Services proposés: tags | 0–8, max 40 characters each
- Structure — Année de création: YYYY | 1950 to current year | optional
- Structure — Projets accompagnés: integer | 0–100 000 | optional
- Structure — Adresse (max 200), Téléphone (0XXXXXXXXX or +213XXXXXXXXX), E-mail, Site web (https://…) | optional
- Structure — Logo: JPG, PNG, WebP, SVG | max 2 MB | optional
- Structure — Projets liés: multi-select | published projects | optional
- Source — Organisme: text | required, max 150 characters
- Source — Dispositif: text | required, max 150 characters
- Source — Catégorie and Sous-catégorie: select | typology A–G of FR-17; the sub-category list depends on the category | required
- Source — Phase: select | "Création / lancement", "Développement", "Les deux" | required
- Source — Public cible: text | optional, max 150 characters
- Source — Description: text | required, 30–1000 characters (FR and AR)
- Source — Conditions d'éligibilité: text | optional, max 1000 characters
- Source — Lien officiel: URL | https://… | optional

**Rules & Constraints:**
- Only published entries appear on the public portal and in search.
- Deleting a structure removes its links to projects; the projects are unchanged.
- The structure page lists the accredited accompagnateurs linked to the structure (FR-36); the link is confirmed by the administrator who grants the accreditation.
- The « Où trouver un appui » category is also a directory filter (FR-16).
- Changing a source's category resets its sub-category.
- Access requires the scope "Contenu de l'Extranet".

**Edge Cases:**
- Structure name already used in the same category → warning "Une structure porte déjà ce nom."
- Invalid web address → "Saisissez une adresse web commençant par https://."
- A support category of FR-10 left without published structure → its "Voir les coordonnées" link is hidden (FR-10).

---

#### FR-69b — Reference Lists

**Description:** A Super-administrator can maintain the value lists used across forms, filters and records, in French and Arabic; the wilaya list is maintained by the development team.
*Source: demo fixed lists in `js/data.js` and `js/intranet-data.js` (`SECTORS`, `WILAYAS`, `STAGES`, `TYPES`, `FILIERES`, thematics, `STAGE_DOCS`); no back-office screen in the demo; v1.0 Q&A Q30, Q58, Q80, Q84.*

**Main Flow:**
1. Super-administrator opens "Listes de référence" and chooses a list.
2. The list shows each value with its French and Arabic labels, order, status (« Actif » / « Inactif ») and number of uses.
3. Super-administrator adds a value, edits a label, reorders or deactivates, and saves.

**Data & Format:**
- Lists: Secteurs; Wilayas (read-only); Formes juridiques; Stades d'avancement publics; Phases du parcours (labels only); Documents requis par phase; Filières; Thématiques de l'Académie; Catégories d'actualité; Types de ressources; Thèmes de replay; Thèmes de sondage
- Libellé FR: text | required, max 60 characters (Documents requis: max 100)
- Libellé AR: text | required, max 60 characters (Documents requis: max 100)
- Ordre: integer | 1–999
- Statut: « Actif » / « Inactif »
- Values at launch: the official list of Algerian wilayas; the sectors Agriculture, Artisanat, Numérique, Éducation, Environnement, Santé, Culture, Tourisme; the filières Agriculture, Santé, Numérique, Artisanat, Autre; the legal forms Association, Coopérative, Fondation, Mutuelle, Entreprise sociale, Entrepreneur individuel, Groupe d'entraide, Projet sans statut juridique; the 12 Académie thematics of the demo

**Rules & Constraints:**
- A value in use cannot be deleted, only deactivated; a deactivated value leaves forms and filters but stays displayed on existing records.
- The four phases are fixed values (the workflow depends on them); only their labels can change.
- The wilaya list is read-only in this screen: wilayas are added by the development team together with their position on the homepage map (FR-07).
- Values entered under « Autre (préciser) » (FR-32) are grouped under « Autre » in filters and statistics (FR-12, FR-71).
- A change to « Documents requis par phase » applies to projects oriented after the change; projects already oriented keep their list.
- Every change is recorded (FR-56).

**Edge Cases:**
- Label already in the list → "Cette valeur existe déjà."
- Arabic label missing → "Le libellé arabe est obligatoire."
- A deactivated value used in a shared link's filter → the filter is ignored (FR-12).

---

#### FR-69c — Platform Settings

**Description:** Super-administrators set the platform-wide parameters: notifications, the delay after which a request is late, social links, the contact mailbox and the sender of e-mails.
*Source: v1.0 Q&A Q16, Q46, Q47, Q54, Q111, Q134 (not in the demo).*

**Main Flow:**
1. Super-administrator opens "Paramètres de la plateforme".
2. Super-administrator edits a section and clicks "Enregistrer".
3. The change applies at once and is recorded in the history (FR-56).

**Data & Format:**
- Notifications: for each notification type of FR-51 — Active (on / off) and Canaux (checkboxes « Dans la plateforme », « E-mail »)
- Délai « En retard »: integer | days, 1–60 | required, default 7
- Réseaux sociaux: Facebook, LinkedIn, X, YouTube | https:// URLs | optional
- Boîte de réception du formulaire de contact: e-mail address | required (address pending the client's answer, Q19)
- Expéditeur des e-mails: name (max 80 characters) and address (on the platform's domain) | required

**Rules & Constraints:**
- The screen is reserved to Super-administrators.
- Account and security e-mails (verification, password reset, sign-in code, change of e-mail address) cannot be switched off.
- An active notification type needs at least one channel.

**Edge Cases:**
- Invalid URL or e-mail address → "Saisissez une adresse valide."
- Every channel unticked on an active type → "Choisissez au moins un canal ou désactivez la notification."
- Two Super-administrators save the same section → the second sees "Ces paramètres ont été modifiés par {nom} à HH:MM."

---

### Module 17 — Back-office: Dashboard & Statistics

#### FR-70 — Work-Queue Dashboard

**Description:** An administrator sees on one screen every request waiting for a decision within their scope, and opens each queue in one click.
*Source: demo `intranet/sadmin-dashboard.html`; v1.0 Q&A Q47, Q50, Q73, Q99, Q110, Q121, Q126 (new queues).*

**Main Flow:**
1. Administrator signs in to "Bonjour, {prénom}" with the button "Historique".
2. Tiles: "Utilisateurs" ("N actifs"), "Projets" ("N en cours"), "Parcours" ("N accompagnements"), "Formations" ("N au catalogue"), "Ressources" ("N documents et replays"); each opens its list.
3. Card « À traiter » lists the queues with their count and "Traiter":
   - projects: "Demandes d'orientation", "Dossiers à valider", "Phases à confirmer", "Sélections à préparer", "Demandes d'élargissement", "Demandes de fin d'accompagnement";
   - accounts: "Demandes d'agrément d'accompagnement", "Renouvellements d'agrément", "Formateur·rice·s à valider", "Modifications de profil à approuver", "Contestations";
   - trainings: "Demandes de validation de formation", "Demandes de suppression de formation";
   - content and messaging: "Contenus à relire", "Conversations signalées", "Messages de contact non traités".
4. Card « Parcours d'accompagnement » shows projects per phase (Pré-incubation, Incubation, Accélération, Financement) and « Terminés », a one-line reading and "Voir le détail" (→ FR-71).

**Data & Format:**
- Counts: integers
- Queue item order: oldest request first
- "Projets en cours": projects with status « Soumis », « Orienté » or « Dossier soumis »

**Rules & Constraints:**
- Only the queues and tiles within the administrator's scope are shown (FR-55); « Contenus à relire » is shown to reviewers only.
- Each count equals the number of items in the list it opens.
- Counts refresh at page load and every 60 seconds.
- A request waiting longer than the delay set in the platform settings (FR-69c, default 7 days) is marked "En retard".

**Edge Cases:**
- Every queue empty → "Rien en attente."
- Scope covers no queue → "Aucune file de traitement dans votre périmètre."
- Item handled by another administrator meanwhile → the count updates within 60 seconds and opening the item shows "Déjà traité par {nom}".

---

#### FR-71 — Statistics and Exports

**Description:** An administrator can follow the platform's activity through charts filtered by period and wilaya, read the underlying data and export it.
*Source: demo `intranet/sadmin-statistiques.html`; TDR (base non relationnelle pour l'analyse des données et son exportation); v1.0 Q&A Q47, Q48, Q84, Q120, Q128.*

**Main Flow:**
1. Administrator opens "Statistiques": tiles "Projets", "En attente de décision", "Formations", "Contributions citoyennes".
2. Charts:
   - « Entonnoir du parcours »: Soumis / Orienté / Dossier déposé / Approuvé, with pass-through rates;
   - « Traitement des demandes »: Dossiers de projet, Formations à publier, Agréments d'accompagnement, Qualifications de formateur·rice, each « À jour », « À traiter » or « En retard »;
   - « Activité »: applications, contributions, training registrations and new accounts per month;
   - « Composition de la communauté »: accounts by role;
   - « Projets par secteur » and « Projets par wilaya »;
   - « Ressources les plus téléchargées » (top 10).
3. Administrator sets the period and the wilaya; every chart updates.
4. Each chart offers "Voir les données" (table) and "Exporter (CSV)".

**Data & Format:**
- Période: date range | DD/MM/YYYY – DD/MM/YYYY | default the last 6 months, max 36 months
- Wilaya: select | "Toutes les wilayas" + wilaya list | default all
- CSV: UTF-8 with BOM, separator ";", header row, one row per data point

**Rules & Constraints:**
- « En retard » means a request waiting longer than the delay set in the platform settings (FR-69c, default 7 days); « À traiter », waiting less; « À jour », none waiting. (The demo used "more than 2 requests".)
- Each figure is counted by its own date: submissions by submission date, approvals by approval date, registrations by registration date, accounts by creation date.
- Projects entered with « Autre (préciser) » are grouped under « Autre » in « Projets par secteur »; a rate that cannot be computed is shown as « — »; requests for additional documents are not counted as refusals.
- Statistics are computed from platform data. The homepage key figures (FR-11) are separate and entered manually.
- Donation pledges are summed and labelled "Promesses (non collectées)".
- Administrator accounts are excluded from « Composition de la communauté ».
- Charts and exports show aggregates only, never personal data.
- Exports are recorded in the history (FR-56); exports over 5 000 rows run in the background.
- Access requires the scope "Statistiques & exports".

**Edge Cases:**
- No data for the period → "Aucune donnée sur la période."
- Period longer than 36 months → "La période ne peut pas dépasser 36 mois."
- Wilaya without project → the tables still list it with zeros.

---

## 5. Non-Functional Requirements

### 5.1 Performance
- Every public page loads within 3 seconds, with its main content visible within 2.5 seconds, on a 4G connection (10 Mbit/s down, 100 ms latency), measured with the Lighthouse mobile profile.
- Member-space and back-office pages load within 3 seconds on the same connection; list filters update within 1 second for lists of up to 10 000 items.
- Site search returns results within 2 seconds for 95 % of queries.
- The platform serves 200 concurrent users — the size of the pilot — with a 95th-percentile server response time of 2 seconds or less, verified by a load test before go-live; the architecture allows the capacity to be raised after the pilot without redesign.
- Every image is delivered at no more than 400 KB at its displayed size, in WebP, with variants at 480, 960 and 1400 px. The homepage weighs at most 2 MB on first load on mobile.
- Exports (CSV and PDF), announcements, e-mail sending and video processing run in a background queue; the interface never waits on them and the user is notified on completion (TDR, « file d'attente »).

### 5.2 Security
- All traffic uses HTTPS (TLS 1.2 or later) with HSTS; HTTP requests are redirected to HTTPS.
- Passwords are hashed with Argon2id or bcrypt (cost 12 or more) and never stored or logged in clear text.
- Every account signs in with a second factor: a 6-digit code sent by e-mail (FR-02). No SMS and no authenticator app are used.
- Access rights — role, account status, administrator scope and ownership of the item — are checked on the server for every request. Checks performed only in the browser, as in the prototype, do not count as access control.
- The application is protected against the OWASP Top 10 (2021) risks, including injection, cross-site scripting (output encoding and a Content-Security-Policy), cross-site request forgery (tokens on every state-changing request) and broken access control. An external penetration test is run before go-live, and go-live requires zero open high or critical findings.
- Uploaded files are checked by content type and size, scanned for malware (held in quarantine while the scanner is unavailable) and stored outside the web root. Private files (dossiers, proofs, CVs, kit, lessons) are served only through authorisation-checked links that are renewed on each request while the user's session is valid, so long videos and slow downloads are not interrupted.
- Repeated sign-in failures are slowed down per device and IP address, never by locking the account (FR-02); rate limits also apply to password reset (FR-03), public forms (FR-30) and the API (100 requests per minute per user by default).
- Session cookies are HttpOnly, Secure and SameSite=Lax; the session identifier is renewed at sign-in.
- Third-party dependencies are scanned monthly for known vulnerabilities; critical fixes are applied within 7 days.
- Personal data is processed in accordance with Algerian Law No. 18-07 of 10 June 2018 on the protection of natural persons in the processing of personal data; the platform's declaration to the national authority (ANPDP) is filed before go-live by the MTESS as data controller (pending validation, Q20).

### 5.3 Usability
- Layouts adapt to three ranges: 1024 px and above (desktop, 3-column grids), 768–1023 px (tablet, 2 columns), below 768 px (mobile, 1 column). Every page works from 360 px wide without horizontal scrolling, and every feature is available on mobile.
- The public portal and the member spaces conform to WCAG 2.1 level AA, verified by an automated scan with zero serious or critical issues and a manual keyboard and screen-reader test of 10 key journeys.
- Every interactive element can be reached and used with the keyboard, with a visible focus indicator; every page starts with a skip link.
- When the user's system requests reduced motion, every animation (photo rotation, carousels, counters, flip cards) is disabled.
- Form inputs use a font size of at least 16 px on mobile, so that iOS Safari does not zoom on focus.
- Every screen defines its empty, loading, error and access-restricted states; no screen is delivered without them.
- Error messages appear next to the field concerned, in the interface language, and state what is wrong and how to correct it.
- In member spaces and the back-office, each screen has one primary action, placed at the top right of its header.
- The French interface uses inclusive writing (porteur·se, accompagnateur·rice, citoyen·ne).
- The Arabic interface is fully mirrored right-to-left (partner logos excepted, FR-08), uses IBM Plex Sans Arabic, and writes numbers and dates with Western digits (1 254).

### 5.4 Compatibility
- Desktop browsers: the latest 2 major versions of Chrome, Firefox, Safari and Edge.
- Mobile browsers: Safari on iOS 15 and later; Chrome on Android 10 and later.
- Screen widths from 360 px to 2560 px.
- No browser plug-in is required; videos play through HTML5 or the embedded YouTube / Vimeo players.
- Server side: a modern web framework (Laravel, Django or equivalent; e.g. PHP 8.1+ runtime) exposing a documented REST API (OpenAPI 3); a relational database (e.g. MySQL 8) for transactions and a NoSQL store for analysis and exports (TDR).
- CSV exports open correctly in Microsoft Excel and LibreOffice Calc (UTF-8 with BOM, separator ";").
- Outgoing e-mail is authenticated with SPF, DKIM and DMARC on the sending domain.

### 5.5 Data & Storage
- The platform, its data, backups and logs are hosted in Algeria (TDR).
- Database and files are backed up automatically every day, encrypted, and kept 30 days; a restore is tested every quarter. Maximum data loss is 24 hours and maximum restore time is 8 hours.
- Monthly availability is at least 99.5 %, excluding planned maintenance announced 48 hours in advance.
- Upload limits: documents 10 MB (resource centre and kit: 20 MB), images 5 MB (media library: 10 MB), videos 500 MB.
- Retention: contact messages 12 months; notifications 12 months; technical journal entries 24 months; decisions kept as long as the record they concern exists; unconfirmed newsletter subscriptions 7 days; inactive accounts anonymised after 3 years. These periods are Trybe's proposal, pending the client's validation (Q20).
- A user can request access to, correction of, or deletion of their personal data; a Super-administrator handles the request within 30 days (pending validation, Q20). On deletion, personal data is erased or anonymised: a project with a team passes to a team member (FR-35), otherwise it is unpublished and anonymised; messages show « Compte supprimé »; decisions are kept without the person's name.
- Every translatable content field is stored in French and Arabic separately.
- At transfer to the national institution, the Super-administrator can export the full content and data of the platform in a documented, open format (SQL dump and files).

---

## 6. Sign-off

*By signing below, the client confirms that the requirements documented above are complete, accurate, and approved for development to begin. Any changes after sign-off are subject to a formal change request and may impact timeline and cost.*

| | Name | Signature | Date |
|---|---|---|---|
| **Client** | | | |
| **Agency** | | | |

---

*Version history*

| Version | Date | Author | Changes |
|---|---|---|---|
| 1.0 | 20 October 2026 | Trybe (SARL AIVOT) | Initial draft — derived from demo V0 and UGP feedback V0 (8 October 2026); supersedes SRS v1.0 « Livrable 1 » (July 2026) |
| 1.1 | 20 October 2026 | Trybe (SARL AIVOT) | Decisions on the v1.0 Q&A incorporated (116 questions resolved, 2 partly); 10 requirements added with letter suffixes (FR-40a, FR-44a, FR-48a, FR-50a, FR-52a, FR-57a, FR-57b, FR-58a, FR-61a, FR-69c); 20 questions remain open with the UGP (QA-SRS.md, Q1–Q20); v1.0 archived in `srs/archive/` |
