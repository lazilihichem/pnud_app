<?php

/*
|--------------------------------------------------------------------------
| Accounts & Access (Module 01) — SRS screen texts
|--------------------------------------------------------------------------
|
| French is the source language. Every key must also exist in
| lang/ar/accounts.php: the fallback locale is 'en', which has no
| accounts file, so a missing Arabic key would show as a raw key.
|
*/

return [

    'registration' => [
        'required' => 'Veuillez remplir les champs obligatoires.',
        'email_taken' => 'Un compte existe déjà avec cette adresse.',
        'passwords_differ' => 'Les mots de passe ne correspondent pas.',
        'cv_format' => 'Format accepté : PDF, DOC, DOCX — 5 Mo maximum.',
    ],

    'sign_in' => [
        'invalid_credentials' => 'Adresse e-mail ou mot de passe incorrect.',
        'suspended' => 'Votre compte est suspendu. Contactez l\'équipe de la plateforme.',
        'refused' => 'Votre inscription n\'a pas été retenue. :reason',
        'throttled' => 'Trop de tentatives. Patientez :seconds secondes avant de réessayer.',
        'code_incorrect' => 'Code incorrect.',
        'code_expired' => 'Code expiré.',
        'code_exhausted' => 'Trop de codes incorrects : ce code n\'est plus valide. Demandez un nouveau code.',
        'code_pending' => 'L\'envoi du code prend plus de temps que prévu.',
        'resend_too_early' => 'Vous pourrez renvoyer le code dans :seconds secondes.',
        'code_sent' => 'Un nouveau code vous a été envoyé.',
        'mail' => [
            'code_subject' => 'Votre code de connexion',
            'code_line' => 'Votre code de connexion est : :code',
            'code_validity' => 'Il est valable 5 minutes et ne sert qu\'une fois.',
            'code_ignore' => 'Si vous n\'êtes pas à l\'origine de cette connexion, changez votre mot de passe.',
            'throttled_subject' => 'Tentatives de connexion à votre compte',
            'throttled_line' => 'Plusieurs tentatives de connexion échouées ont visé votre compte. Elles sont désormais ralenties.',
            'throttled_safe' => 'Votre compte n\'est pas bloqué. Si ce n\'était pas vous, nous vous conseillons de changer votre mot de passe.',
        ],
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
