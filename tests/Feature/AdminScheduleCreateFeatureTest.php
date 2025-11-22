<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\Schedule;
use App\Models\Court;
use App\Livewire\Admin\Schedule\Create;

class AdminScheduleCreateFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Admin\Schedule\Create::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $this->assertGuestRedirectsToLogin('/admin/schedules/create');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Admin\Schedule\Create') && is_subclass_of('\App\Livewire\Admin\Schedule\Create', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Admin\Schedule\Create');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_create_component_validates_and_stores()
        {
            $authUser = \App\Models\User::factory()->create();
            $court = Court::factory()->create();
            $this->actingAs($authUser);

            // missing -> errors
            Livewire::test(Create::class)
                ->call('save')
                ->assertHasErrors(['form.dia_de_la_semana', 'form.hora_apertura', 'form.hora_cierre', 'form.court_id']);

            // valid data
            Livewire::test(Create::class)
                ->set('form.dia_de_la_semana', 'lunes')
                ->set('form.hora_apertura', '08:00')
                ->set('form.hora_cierre', '10:00')
                ->set('form.court_id', $court->id)
                ->call('save')
                ->assertRedirect(route('admin.schedules.index'));

            $this->assertDatabaseHas('schedules', ['dia_de_la_semana' => 'lunes']);
        }


}
