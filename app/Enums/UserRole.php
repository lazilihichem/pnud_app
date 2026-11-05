<?php

namespace App\Enums;

/**
 * The role stored on an account, fixed at registration (SRS §3, FR-01).
 */
enum UserRole: string
{
    case Entrepreneur = 'entrepreneur';
    case Accompagnateur = 'accompagnateur';
    case Formateur = 'formateur';
    case Citoyen = 'citoyen';
    case Admin = 'admin';
    case SuperAdmin = 'super_admin';

    /**
     * The profiles a visitor can choose at registration.
     *
     * @return list<self>
     */
    public static function selfRegistrable(): array
    {
        return [self::Entrepreneur, self::Accompagnateur, self::Formateur, self::Citoyen];
    }

    /**
     * Whether the role belongs to the back-office.
     */
    public function isAdministrator(): bool
    {
        return in_array($this, [self::Admin, self::SuperAdmin], true);
    }

    /**
     * The account status given at registration (FR-01).
     */
    public function initialStatus(): AccountStatus
    {
        return match ($this) {
            self::Accompagnateur => AccountStatus::NotValidated,
            self::Formateur => AccountStatus::NotQualified,
            self::Admin, self::SuperAdmin => AccountStatus::Invited,
            self::Entrepreneur, self::Citoyen => AccountStatus::Active,
        };
    }

    /**
     * The named route of the role's home.
     *
     * Every member role lands on the dashboard until the role homes exist
     * (Accompagnateur: FR-36, Formateur « Ma qualification »: FR-46).
     */
    public function homeRoute(): string
    {
        return 'platform.dashboard';
    }
}
