<?php

namespace App\Models\Accounts;

use App\Models\User;
use Database\Factories\Accounts\CitoyenProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * The Citoyen part of an account (ProfileType::Citoyen). No own fields yet.
 *
 * @property int $id
 */
class CitoyenProfile extends Model
{
    /** @use HasFactory<CitoyenProfileFactory> */
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
