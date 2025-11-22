<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class VerifyEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirects_when_user_already_verified()
    {
        // Arrange
        $user = User::factory()->create(['email_verified_at' => now()]);
        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(30),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // Act
        $response = $this->actingAs($user)->get($url);

        // Assert
        $response->assertRedirect(route('dashboard').'?verified=1');
    }

    public function test_fulfills_and_redirects_when_user_not_verified()
    {
        // Arrange
        $user = User::factory()->create(['email_verified_at' => null]);
        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(30),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // Act
        $response = $this->actingAs($user)->get($url);

        // Assert
        $response->assertRedirect(route('dashboard').'?verified=1');
        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
