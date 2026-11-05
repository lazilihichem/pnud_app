<?php

namespace App\Models\Accounts;

use App\Models\User;
use Database\Factories\Accounts\TrainerProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * The Formateur part of an account (ERD: Accounts/TrainerProfile). The CV is a Media in the `cv` collection.
 *
 * @property int $id
 * @property string|null $linkedin_url
 * @property string $education
 * @property Carbon|null $test_passed_at
 */
#[Fillable(['linkedin_url', 'education'])]
class TrainerProfile extends Model implements HasMedia
{
    /** @use HasFactory<TrainerProfileFactory> */
    use HasFactory, InteractsWithMedia;

    public const string CvCollection = 'cv';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'test_passed_at' => 'datetime',
        ];
    }

    /**
     * Register the media collections: a single private CV.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::CvCollection)
            ->singleFile()
            ->useDisk('local');
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
