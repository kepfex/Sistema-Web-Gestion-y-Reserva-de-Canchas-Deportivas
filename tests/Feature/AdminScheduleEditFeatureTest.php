<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\Schedule;
use App\Livewire\Admin\Schedule\Edit;

class AdminScheduleEditFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Admin\Schedule\Edit::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $schedule = \App\Models\Schedule::factory()->create();
                $this->assertGuestRedirectsToLogin('/admin/schedules/'.$schedule->id.'/edit');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Admin\Schedule\Edit') && is_subclass_of('\App\Livewire\Admin\Schedule\Edit', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Admin\Schedule\Edit');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_edit_component_updates_schedule()
        {
            $authUser = \App\Models\User::factory()->create();
            $schedule = Schedule::factory()->create(['dia_de_la_semana' => 'miércoles']);
            $this->actingAs($authUser);

            Livewire::test(Edit::class, ['schedule' => $schedule])
                ->set('form.hora_apertura', '08:00')
                ->set('form.hora_cierre', '10:00')
                ->set('form.dia_de_la_semana', 'jueves')
                ->call('save')
                ->assertRedirect(route('admin.schedules.index'));

            $this->assertDatabaseHas('schedules', ['id' => $schedule->id, 'dia_de_la_semana' => 'jueves']);
        }


}
