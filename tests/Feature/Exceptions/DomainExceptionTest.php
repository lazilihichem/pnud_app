<?php

namespace Tests\Feature\Exceptions;

use App\Exceptions\DomainException;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DomainExceptionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware('web')->post('_test/domain-exception', function () {
            throw new class('Project already published.') extends DomainException {};
        });
    }

    public function test_inertia_request_redirects_back_with_an_error_toast(): void
    {
        $response = $this->from('/previous')->post('_test/domain-exception');

        $response->assertRedirect('/previous');
        $response->assertInertiaFlash('toast', ['type' => 'error', 'message' => 'Project already published.']);
    }

    public function test_json_request_returns_422_with_the_message(): void
    {
        $response = $this->postJson('_test/domain-exception');

        $response->assertUnprocessable();
        $response->assertExactJson(['message' => 'Project already published.']);
    }
}
