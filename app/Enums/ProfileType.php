<?php

namespace App\Enums;

use App\Models\Accounts\AccompagnateurProfile;
use App\Models\Accounts\AdminProfile;
use App\Models\Accounts\CitoyenProfile;
use App\Models\Accounts\EntrepreneurProfile;
use App\Models\Accounts\TrainerProfile;
use Illuminate\Database\Eloquent\Model;

/**
 * The kind of account (SRS §3, FR-01): every user has exactly one profile, stored in
 * users.profilable_type / profilable_id. The values are the morph-map aliases, so the
 * type is read straight from profilable_type. Administrators and super administrators
 * share the admin profile (`is_super_admin`).
 */
enum ProfileType: string
{
    case Admin = 'admin';
    case Entrepreneur = 'entrepreneur';
    case Accompagnateur = 'accompagnateur';
    case Formateur = 'formateur';
    case Citoyen = 'citoyen';

    /**
     * The profile model of each type, registered as the enforced morph map.
     *
     * @return array<string, class-string<Model>>
     */
    public static function morphMap(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn (self $type): string => $type->modelClass(), self::cases()),
        );
    }

    /**
     * The profiles a visitor can choose at registration (FR-01).
     *
     * @return list<self>
     */
    public static function selfRegistrable(): array
    {
        return [self::Entrepreneur, self::Accompagnateur, self::Formateur, self::Citoyen];
    }

    /**
     * The profile model of this type.
     *
     * @return class-string<AdminProfile|EntrepreneurProfile|AccompagnateurProfile|TrainerProfile|CitoyenProfile>
     */
    public function modelClass(): string
    {
        return match ($this) {
            self::Admin => AdminProfile::class,
            self::Entrepreneur => EntrepreneurProfile::class,
            self::Accompagnateur => AccompagnateurProfile::class,
            self::Formateur => TrainerProfile::class,
            self::Citoyen => CitoyenProfile::class,
        };
    }

    /**
     * The account status given at creation (FR-01, FR-55).
     */
    public function initialStatus(): AccountStatus
    {
        return match ($this) {
            self::Accompagnateur => AccountStatus::NotValidated,
            self::Formateur => AccountStatus::NotQualified,
            self::Admin => AccountStatus::Invited,
            self::Entrepreneur, self::Citoyen => AccountStatus::Active,
        };
    }
}
