<?php

namespace Database\Seeders;

use App\Models\Reference\Wilaya;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(WilayaSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'wilaya_id' => Wilaya::query()->where('code', '16')->value('id'),
        ]);
    }
}
