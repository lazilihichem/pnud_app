<?php

namespace App\Enums;

/**
 * The malware scan result of an uploaded file (ERD: Media.scan_status).
 */
enum ScanStatus: string
{
    /** « En cours de vérification » — visible only to its uploader. */
    case Pending = 'en_attente';

    case Clean = 'sain';

    case Blocked = 'bloque';
}
