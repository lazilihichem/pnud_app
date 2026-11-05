<?php

namespace Tests\Feature\Http\Middleware;

use App\Http\Middleware\EnsureAdminAccess;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class EnsureAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // routes/admin.php has no routes yet, so exercise the middleware on a test route.
        Route::middleware(['web', EnsureAdminAccess::class])
            ->get('/{locale}/admin/test-page', fn () => 'admin page');
    }

    public function test_guest_is_redirected_to_the_login_page(): void
    {
        $response = $this->get('/ar/admin/test-page');

        $response->assertRedirect('/ar/login');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_access_the_admin_area(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/ar/admin/test-page');

        $response->assertOk();
        $response->assertSee('admin page');
    }
}
