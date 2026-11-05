<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Features;

abstract class TestCase extends BaseTestCase
{
    /**
     * The locale used when generating route URLs in tests.
     */
    protected string $locale = 'fr';

    protected function setUp(): void
    {
        parent::setUp();

        URL::defaults(['locale' => $this->locale]);
    }

    protected function skipUnlessFortifyHas(string $feature, ?string $message = null): void
    {
        if (! Features::enabled($feature)) {
            $this->markTestSkipped($message ?? "Fortify feature [{$feature}] is not enabled.");
        }
    }
}
