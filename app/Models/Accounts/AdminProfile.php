<?php

namespace App\Models\Accounts;

use App\Models\User;
use Database\Factories\Accounts\AdminProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * The back-office part of an account (ProfileType::Admin): administrators and super
 * administrators share it, `is_super_admin` tells them apart. Admin scopes (ERD
 * AdminScope) will attach to this profile.
 *
 * @property int $id
 * @property bool $is_super_admin
 */
class AdminProfile extends Model
{
    /** @use HasFactory<AdminProfileFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_super_admin' => 'boolean',
        ];
    }

    /**
     * The account this profile belongs to.
     *
     * @return MorphOne<User, $this>
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profilable');
    }
}
