<?php

/*
|--------------------------------------------------------------------------
| Accounts & Access (Module 01) — SRS screen texts
|--------------------------------------------------------------------------
|
| French is the source language and the fallback: a key missing from
| lang/ar is shown in French until the client supplies the translation.
|
*/

return [

    'registration' => [
        'required' => 'Veuillez remplir les champs obligatoires.',
        'email_taken' => 'Un compte existe déjà avec cette adresse.',
        'passwords_differ' => 'Les mots de passe ne correspondent pas.',
        'cv_format' => 'Format accepté : PDF, DOC, DOCX — 5 Mo maximum.',
    ],

    'attributes' => [
        'role' => 'Je suis',
        'name' => 'Nom complet',
        'email' => 'E-mail',
        'organisation' => 'Organisation',
        'wilaya_id' => 'Wilaya',
        'fonction' => 'Fonction / spécialité',
        'linkedin_url' => 'Profil LinkedIn',
        'education' => 'Formation / diplômes',
        'cv' => 'CV',
        'password' => 'Mot de passe',
        'password_confirmation' => 'Confirmer le mot de passe',
        'terms' => "J'accepte les conditions d'utilisation",
    ],

    'roles' => [
        'entrepreneur' => 'Entrepreneur / organisation ESS',
        'accompagnateur' => 'Accompagnateur',
        'formateur' => 'Formateur',
        'citoyen' => 'Citoyen',
        'admin' => 'Administrateur',
        'super_admin' => 'Super administrateur',
    ],

];
