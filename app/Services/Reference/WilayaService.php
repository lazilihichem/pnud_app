<?php

namespace App\Services\Reference;

use App\Models\Reference\Wilaya;

class WilayaService
{
    /**
     * The wilayas as select options, in official order, named in the current language.
     *
     * @return array<int, array{value: int, label: string}>
     */
    public function options(): array
    {
        return Wilaya::query()
            ->orderBy('position')
            ->get()
            ->map(fn (Wilaya $wilaya): array => [
                'value' => $wilaya->id,
                'label' => "{$wilaya->code} — {$wilaya->localizedName()}",
            ])
            ->values()
            ->all();
    }
}
