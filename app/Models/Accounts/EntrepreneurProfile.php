<?php

namespace App\Models\Accounts;

use App\Models\User;
use Database\Factories\Accounts\EntrepreneurProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * The Entrepreneur / organisation ESS part of an account (ProfileType::Entrepreneur). No own fields yet.
 *
 * @property int $id
 */
class EntrepreneurProfile extends Model
{
    /** @use HasFactory<EntrepreneurProfileFactory> */
    use HasFactory;

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
