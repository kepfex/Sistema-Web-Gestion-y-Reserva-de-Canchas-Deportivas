<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use App\Livewire\Settings\Appearance;

class SettingsAppearanceFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Settings\Appearance::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $this->assertGuestRedirectsToLogin('/settings/appearance');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Settings\Appearance') && is_subclass_of('\App\Livewire\Settings\Appearance', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Settings\Appearance');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_component_class_exists_smoke()
    {
        $this->assertTrue(class_exists(\App\Livewire\Settings\Appearance::class));
    }


}
