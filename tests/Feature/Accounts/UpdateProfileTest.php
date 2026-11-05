<?php

namespace Tests\Feature\Accounts;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_mixed_case_email_is_stored_lowercased(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('platform.profile.update'), [
            'name' => $user->name,
            'email' => ' Amina@Exemple.DZ ',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertSame('amina@exemple.dz', $user->refresh()->email);
    }

    public function test_case_variant_of_another_accounts_email_is_rejected(): void
    {
        User::factory()->create(['email' => 'john@exemple.dz']);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('platform.profile.update'), [
            'name' => $user->name,
            'email' => 'JOHN@exemple.dz',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertNotSame('john@exemple.dz', $user->refresh()->email);
    }
}
