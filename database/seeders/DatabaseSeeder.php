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

        $algiers = Wilaya::query()->where('code', '16')->value('id');

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'wilaya_id' => $algiers,
        ]);

        // Local back-office account (never seeded outside the local environment).
        if (app()->environment('local')) {
            User::factory()->admin(super: true)->create([
                'name' => 'Super Admin ESS',
                'email' => 'admin@ess.dz',
                'password' => 'AdminEss2026!',
                'wilaya_id' => $algiers,
            ]);
        }
    }
}
