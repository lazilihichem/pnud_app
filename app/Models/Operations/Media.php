<?php

namespace App\Models\Operations;

use App\Enums\ScanStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

/**
 * A file attached to a model by collection (ERD: Media). Private by default.
 *
 * @property ScanStatus $scan_status
 * @property int|null $uploaded_by
 */
class Media extends BaseMedia
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scan_status' => ScanStatus::class,
        ];
    }

    /**
     * The user who uploaded the file.
     *
     * @return BelongsTo<User, $this>
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
