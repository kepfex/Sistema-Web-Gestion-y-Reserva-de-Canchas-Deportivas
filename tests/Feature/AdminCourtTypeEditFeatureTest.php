<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use App\Livewire\Admin\CourtType\Edit;

class AdminCourtTypeEditFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Admin\CourtType\Edit::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $courtType = \App\Models\CourtType::factory()->create();
                $this->assertGuestRedirectsToLogin('/admin/court-types/'.$courtType->id.'/edit');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Admin\CourtType\Edit') && is_subclass_of('\App\Livewire\Admin\CourtType\Edit', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Admin\CourtType\Edit');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_component_class_exists_smoke()
    {
        $this->assertTrue(class_exists(\App\Livewire\Admin\CourtType\Edit::class));
    }


}
