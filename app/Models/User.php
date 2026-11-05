<?php

namespace App\Models;

use App\Enums\AccountStatus;
use App\Enums\Locale;
use App\Enums\ProfileType;
use App\Models\Accounts\AdminProfile;
use App\Models\Accounts\SignInCode;
use App\Models\Reference\Wilaya;
use App\Notifications\Accounts\VerifyEmailNotification;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property ProfileType $type
 * @property string $profilable_type
 * @property int $profilable_id
 * @property-read Model $profile
 * @property AccountStatus $status
 * @property AccountStatus|null $status_before_suspension
 * @property string|null $status_reason
 * @property string|null $organisation
 * @property int|null $wilaya_id
 * @property string|null $phone
 * @property Locale $locale
 * @property string|null $terms_version
 * @property Carbon|null $terms_accepted_at
 * @property bool $must_change_password
 * @property Carbon|null $invitation_expires_at
 * @property Carbon|null $last_login_at
 * @property Carbon|null $anonymised_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'email', 'password', 'organisation', 'wilaya_id', 'phone'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail, PasskeyUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => AccountStatus::class,
            'status_before_suspension' => AccountStatus::class,
            'locale' => Locale::class,
            'terms_accepted_at' => 'datetime',
            'must_change_password' => 'boolean',
            'invitation_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'anonymised_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * The e-mail is stored lowercased: one account per address whatever its case, and sign-in
     * looks addresses up in lowercase.
     *
     * @return Attribute<string, string>
     */
    protected function email(): Attribute
    {
        return Attribute::make(set: fn (string $value): string => mb_strtolower(trim($value)));
    }

    /**
     * Send the queued e-mail verification link (FR-01).
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * The wilaya the account is located in.
     *
     * @return BelongsTo<Wilaya, $this>
     */
    public function wilaya(): BelongsTo
    {
        return $this->belongsTo(Wilaya::class);
    }

    /**
     * The account's profile: AdminProfile, EntrepreneurProfile, AccompagnateurProfile,
     * TrainerProfile or CitoyenProfile, depending on the type.
     *
     * @return MorphTo<Model, $this>
     */
    public function profile(): MorphTo
    {
        return $this->morphTo('profile', 'profilable_type', 'profilable_id');
    }

    /**
     * The kind of account, read from and written to profilable_type (the morph-map alias):
     * setting it picks the profile model the account's profilable_id points to.
     *
     * @return Attribute<ProfileType, ProfileType|string>
     */
    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): ProfileType => ProfileType::from($attributes['profilable_type']),
            set: fn (ProfileType|string $value): array => [
                'profilable_type' => ProfileType::from($value instanceof ProfileType ? $value->value : $value)->value,
            ],
        );
    }

    /**
     * Whether the account belongs to the back-office (administrator or super administrator).
     */
    public function isAdministrator(): bool
    {
        return $this->type === ProfileType::Admin;
    }

    /**
     * Whether the account is a super administrator (admin profile flagged is_super_admin).
     */
    public function isSuperAdmin(): bool
    {
        return $this->isAdministrator() && $this->profile instanceof AdminProfile && $this->profile->is_super_admin;
    }

    /**
     * The sign-in codes sent to the account.
     *
     * @return HasMany<SignInCode, $this>
     */
    public function signInCodes(): HasMany
    {
        return $this->hasMany(SignInCode::class);
    }

    /**
     * Whether the account confirmed an authenticator app (optional, on top of the e-mail code).
     */
    public function hasConfirmedTwoFactor(): bool
    {
        return $this->two_factor_secret !== null && $this->two_factor_confirmed_at !== null;
    }

    /**
     * The e-mail address with its local part hidden, as shown on the code step (« a•••@exemple.dz »).
     */
    public function maskedEmail(): string
    {
        [$local, $domain] = explode('@', $this->email, 2) + [1 => ''];

        return mb_substr($local, 0, 1).'•••@'.$domain;
    }
}
