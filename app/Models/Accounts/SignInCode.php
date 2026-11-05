<?php

namespace App\Models\Accounts;

use App\Models\User;
use Database\Factories\Accounts\SignInCodeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * A 6-digit sign-in code sent by e-mail (ERD: Accounts/SignInCode, FR-02).
 *
 * @property int $id
 * @property int $user_id
 * @property string $code_hash
 * @property Carbon|null $delivered_at
 * @property Carbon|null $expires_at
 * @property int $failed_attempts
 * @property Carbon|null $used_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['code_hash'])]
#[Hidden(['code_hash'])]
class SignInCode extends Model
{
    /** @use HasFactory<SignInCodeFactory> */
    use HasFactory;

    /**
     * Minutes a code stays valid, counted from its delivery.
     */
    public const int LifetimeMinutes = 5;

    /**
     * Wrong entries that invalidate a code.
     */
    public const int MaxFailedAttempts = 3;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'delivered_at' => 'datetime',
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    /**
     * The account the code signs in.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Whether the code e-mail has not been delivered yet.
     */
    public function isPendingDelivery(): bool
    {
        return $this->delivered_at === null;
    }

    /**
     * Whether the code's 5 minutes are over.
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    /**
     * Whether 3 wrong entries have invalidated the code.
     */
    public function isExhausted(): bool
    {
        return $this->failed_attempts >= self::MaxFailedAttempts;
    }
}
