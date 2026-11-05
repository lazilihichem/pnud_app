<?php

namespace App\Models\Accounts;

use App\Models\User;
use Database\Factories\Accounts\AccompagnateurProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * The Accompagnateur part of an account (ERD: Accounts/AccompagnateurProfile).
 *
 * @property int $id
 * @property string $fonction
 * @property int $capacity
 * @property string|null $presentation
 */
#[Fillable(['fonction', 'presentation'])]
class AccompagnateurProfile extends Model
{
    /** @use HasFactory<AccompagnateurProfileFactory> */
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
