<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use Mockery;
use Illuminate\Http\RedirectResponse;

class VerifyEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoke_does_not_call_fulfill_if_user_already_verified()
    {
        // Arrange
        $user = User::factory()->create(['email_verified_at' => now()]);

        $request = Mockery::mock(EmailVerificationRequest::class);
        $request->shouldReceive('user')->andReturn($user);
        // fulfill should not be called when already verified
        $request->shouldReceive('fulfill')->never();

        // Act
        $controller = new VerifyEmailController();
        $response = $controller->__invoke($request);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('?verified=1', $response->getTargetUrl());
    }

    public function test_invoke_calls_fulfill_when_user_not_verified()
    {
        // Arrange
        $user = User::factory()->create(['email_verified_at' => null]);

        $request = Mockery::mock(EmailVerificationRequest::class);
        $request->shouldReceive('user')->andReturn($user);
        // Expect fulfill to be called once
        $request->shouldReceive('fulfill')->once();

        // Act
        $controller = new VerifyEmailController();
        $response = $controller->__invoke($request);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('?verified=1', $response->getTargetUrl());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
