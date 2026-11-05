<?php

namespace App\Models;

use App\Enums\AccountStatus;
use App\Enums\Locale;
use App\Enums\UserRole;
use App\Models\Accounts\AccompagnateurProfile;
use App\Models\Accounts\TrainerProfile;
use App\Models\Reference\Wilaya;
use App\Notifications\Accounts\VerifyEmailNotification;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @property UserRole $role
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
            'role' => UserRole::class,
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
     * The Accompagnateur profile, for Accompagnateur accounts.
     *
     * @return HasOne<AccompagnateurProfile, $this>
     */
    public function accompagnateurProfile(): HasOne
    {
        return $this->hasOne(AccompagnateurProfile::class);
    }

    /**
     * The Formateur profile, for Formateur accounts.
     *
     * @return HasOne<TrainerProfile, $this>
     */
    public function trainerProfile(): HasOne
    {
        return $this->hasOne(TrainerProfile::class);
    }
}
