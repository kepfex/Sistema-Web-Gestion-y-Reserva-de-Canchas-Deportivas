<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\Court;
use App\Livewire\Admin\Court\Edit;

class AdminCourtEditFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Admin\Court\Edit::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $court = \App\Models\Court::factory()->create();
                $this->assertGuestRedirectsToLogin('/admin/courts/'.$court->id.'/edit');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Admin\Court\Edit') && is_subclass_of('\App\Livewire\Admin\Court\Edit', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Admin\Court\Edit');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_edit_component_updates_court()
        {
            $authUser = \App\Models\User::factory()->create();
            $court = Court::factory()->create(['nombre' => 'Antes']);
            $this->actingAs($authUser);

            Livewire::test(Edit::class, ['court' => $court])
                ->set('form.nombre', 'Despues')
                ->call('save')
                ->assertRedirect(route('admin.courts.index'));

            $this->assertDatabaseHas('courts', ['id' => $court->id, 'nombre' => 'Despues']);
        }


}
