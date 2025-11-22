<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;


abstract class TestCase extends BaseTestCase
{
    /**
     * Assert that a guest visiting the given path is redirected to login.
     * If the path is not defined or returns 200, the assertion will fail.
     */
    protected function assertGuestRedirectsToLogin(string $path): void
    {
        $response = $this->get($path);
        if ($response->isRedirection()) {
            $location = $response->headers->get('Location') ?? '';
            $this->assertStringContainsString('/login', $location, "Expected redirect to login for {$path}, got {$location}");
            return;
        }

        $this->fail("Expected guest to be redirected from {$path} to login, got status {$response->getStatusCode()}");
    }
}
