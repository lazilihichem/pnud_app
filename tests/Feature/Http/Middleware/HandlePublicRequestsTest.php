<?php

namespace Tests\Feature\Http\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HandlePublicRequestsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'inertia.ssr.enabled' => true,
            'inertia.ssr.ensure_bundle_exists' => false,
        ]);

        Http::fake([
            '*/render' => Http::response([
                'head' => ['<title>Bienvenue</title>'],
                'body' => '<div id="app" data-server-rendered="true">Bienvenue</div>',
            ]),
        ]);
    }

    public function test_public_page_is_server_side_rendered_for_guests(): void
    {
        $response = $this->get('/fr');

        $response->assertOk();
        $response->assertSee('data-server-rendered="true"', escape: false);
        Http::assertSent(fn (Request $request) => str_ends_with($request->url(), '/render')
            && $request['component'] === 'Welcome');
    }

    public function test_public_page_is_not_server_side_rendered_when_ssr_is_disabled(): void
    {
        config(['inertia.ssr.enabled' => false]);

        $response = $this->get('/fr');

        $response->assertOk();
        Http::assertNothingSent();
    }

    public function test_platform_page_is_not_server_side_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/fr/platform/dashboard');

        $response->assertOk();
        Http::assertNothingSent();
    }

    public function test_authentication_page_is_not_server_side_rendered(): void
    {
        $response = $this->get('/fr/login');

        $response->assertOk();
        Http::assertNothingSent();
    }
}
