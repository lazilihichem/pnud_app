<?php

namespace Tests\Feature\Http\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnsurePlatformAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_the_login_page(): void
    {
        $response = $this->get('/fr/platform/dashboard');

        $response->assertRedirect('/fr/login');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_access_the_platform(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/fr/platform/dashboard');

        $response->assertOk();
    }

    public function test_guest_cannot_reach_platform_routes_without_their_own_auth_middleware(): void
    {
        $response = $this->get('/fr/platform/settings/profile');

        $response->assertRedirect('/fr/login');
    }
}
