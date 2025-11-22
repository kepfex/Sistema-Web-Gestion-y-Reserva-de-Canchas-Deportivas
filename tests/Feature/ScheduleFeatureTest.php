<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Schedule;
use App\Models\Court;
use Livewire\Livewire;
use App\Livewire\Admin\Schedule\Index as ScheduleIndex;
use App\Livewire\Admin\Schedule\Create as ScheduleCreate;
use App\Livewire\Admin\Schedule\Edit as ScheduleEdit;

class ScheduleFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_schedules_routes()
    {
        $this->get(route('admin.schedules.index'))->assertRedirect(route('login'));
        $this->get(route('admin.schedules.create'))->assertRedirect(route('login'));

        $schedule = Schedule::factory()->create();
        $this->get(route('admin.schedules.edit', $schedule))->assertRedirect(route('login'));
    }

    public function test_index_shows_schedules()
    {
        $authUser = \App\Models\User::factory()->create();
        Schedule::factory()->create(['dia_de_la_semana' => 'martes']);
        $this->actingAs($authUser);

        Livewire::test(ScheduleIndex::class)
            ->assertSee('Horarios')
            ->assertSee('martes');
    }

    public function test_create_component_validates_and_stores()
    {
        $authUser = \App\Models\User::factory()->create();
        $court = Court::factory()->create();
        $this->actingAs($authUser);

        // missing -> errors
        Livewire::test(ScheduleCreate::class)
            ->call('save')
            ->assertHasErrors(['form.dia_de_la_semana', 'form.hora_apertura', 'form.hora_cierre', 'form.court_id']);

        // valid data
        Livewire::test(ScheduleCreate::class)
            ->set('form.dia_de_la_semana', 'lunes')
            ->set('form.hora_apertura', '08:00')
            ->set('form.hora_cierre', '10:00')
            ->set('form.court_id', $court->id)
            ->call('save')
            ->assertRedirect(route('admin.schedules.index'));

        $this->assertDatabaseHas('schedules', ['dia_de_la_semana' => 'lunes']);
    }

    public function test_edit_component_updates_schedule()
    {
        $authUser = \App\Models\User::factory()->create();
        $schedule = Schedule::factory()->create(['dia_de_la_semana' => 'miércoles']);
        $this->actingAs($authUser);

        Livewire::test(ScheduleEdit::class, ['schedule' => $schedule])
            ->set('form.hora_apertura', '08:00')
            ->set('form.hora_cierre', '10:00')
            ->set('form.dia_de_la_semana', 'jueves')
            ->call('save')
            ->assertRedirect(route('admin.schedules.index'));

        $this->assertDatabaseHas('schedules', ['id' => $schedule->id, 'dia_de_la_semana' => 'jueves']);
    }

    public function test_index_component_can_delete_schedule()
    {
        $authUser = \App\Models\User::factory()->create();
        $schedule = Schedule::factory()->create();
        $this->actingAs($authUser);

        Livewire::test(ScheduleIndex::class)
            ->call('deleteSchedule', $schedule->id);

        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }
}
