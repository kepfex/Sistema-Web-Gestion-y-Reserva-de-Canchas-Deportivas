<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use App\Livewire\Actions\Logout;

class ActionsLogoutFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Actions\Logout::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $response = $this->post('/logout');
                $response->assertRedirect('/');
    }



            public function test_authenticated_user_can_mount_component()
    {
                $user = \App\Models\User::factory()->create();
                $this->actingAs($user);

                // The logout action is an invokable class that redirects; assert POST /logout works for authenticated users.
                $response = $this->post('/logout');
                $response->assertRedirect('/');
    }



        public function test_component_class_exists_smoke()
    {
        $this->assertTrue(class_exists(\App\Livewire\Actions\Logout::class));
    }


}
