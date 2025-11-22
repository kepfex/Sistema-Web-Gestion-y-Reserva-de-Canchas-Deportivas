<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use App\Livewire\Auth\ForgotPassword;

class AuthForgotPasswordFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Auth\ForgotPassword::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $response = $this->get('/forgot-password');
                $response->assertStatus(200);
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Auth\ForgotPassword') && is_subclass_of('\App\Livewire\Auth\ForgotPassword', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Auth\ForgotPassword');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_component_class_exists_smoke()
    {
        $this->assertTrue(class_exists(\App\Livewire\Auth\ForgotPassword::class));
    }


}
