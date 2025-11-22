<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\Court;
use App\Models\CourtType;
use App\Livewire\Admin\Court\Create;

class AdminCourtCreateFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Admin\Court\Create::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $this->assertGuestRedirectsToLogin('/admin/courts/create');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Admin\Court\Create') && is_subclass_of('\App\Livewire\Admin\Court\Create', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Admin\Court\Create');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_create_component_validates_and_stores()
        {
            $authUser = \App\Models\User::factory()->create();
            $courtType = CourtType::factory()->create();
            $this->actingAs($authUser);

            // missing fields => validation
            Livewire::test(Create::class)
                ->call('save')
                ->assertHasErrors(['form.court_type_id', 'form.nombre']);

            // valid data
            Livewire::test(Create::class)
                ->set('form.court_type_id', $courtType->id)
                ->set('form.nombre', 'Nueva Cancha')
                ->set('form.medidas', '20m x 40m')
                ->set('form.ubicacion', 'Centro')
                ->set('form.disponible', true)
                ->call('save')
                ->assertRedirect(route('admin.courts.index'));

            $this->assertDatabaseHas('courts', ['nombre' => 'Nueva Cancha']);
        }


}
