<?php

namespace App\Models\Reference;

use App\Enums\Locale;
use App\Models\User;
use Database\Factories\Reference\WilayaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

/**
 * One of the official wilayas (ERD: Reference/Wilaya).
 *
 * @property int $id
 * @property string $code
 * @property array{fr: string, ar: string} $name
 * @property string|null $map_x
 * @property string|null $map_y
 * @property int $position
 */
#[Fillable(['code', 'name', 'map_x', 'map_y', 'position'])]
class Wilaya extends Model
{
    /** @use HasFactory<WilayaFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => 'array',
            'map_x' => 'decimal:2',
            'map_y' => 'decimal:2',
        ];
    }

    /**
     * The name in the given language, French when missing (SRS 5.5).
     */
    public function localizedName(?Locale $locale = null): string
    {
        $locale ??= Locale::tryFrom(App::getLocale()) ?? Locale::French;

        return $this->name[$locale->value] ?? $this->name[Locale::French->value];
    }

    /**
     * The accounts located in this wilaya.
     *
     * @return HasMany<User, $this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
