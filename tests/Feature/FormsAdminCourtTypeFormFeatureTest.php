<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use App\Livewire\Forms\Admin\CourtTypeForm;

class FormsAdminCourtTypeFormFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Forms\Admin\CourtTypeForm::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $this->assertGuestRedirectsToLogin('/admin/court-types/create');
    }



            public function test_authenticated_user_can_mount_component()
    {
                $user = \App\Models\User::factory()->create();
                $this->actingAs($user);
                $fqcn = '\App\\Livewire\\Forms\\Admin\\CourtTypeForm';
                if (class_exists($fqcn) && is_subclass_of($fqcn, \Livewire\Component::class)) {
                    Livewire::test($fqcn);
                    $this->assertTrue(true);
                    return;
                }

                $response = $this->actingAs($user)->get('/admin/court-types/create');
                $this->assertFalse($response->isRedirection(), 'Authenticated user was redirected when accessing admin court-types create');
    }



        public function test_component_class_exists_smoke()
    {
        $this->assertTrue(class_exists(\App\Livewire\Forms\Admin\CourtTypeForm::class));
    }


}
