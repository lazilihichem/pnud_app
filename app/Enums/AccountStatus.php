<?php

namespace App\Enums;

/**
 * The status of an account (ERD: AccountStatus).
 */
enum AccountStatus: string
{
    /** « Qualification à passer » */
    case NotQualified = 'non_qualifie';

    /** « Inactif » */
    case NotValidated = 'non_valide';

    /** « En attente de validation » */
    case PendingValidation = 'en_attente';

    /** « Invitation envoyée » */
    case Invited = 'invite';

    /** « Actif » */
    case Active = 'actif';

    /** « Suspendu » */
    case Suspended = 'suspendu';

    /** « Refusé » */
    case Refused = 'refuse';
}
