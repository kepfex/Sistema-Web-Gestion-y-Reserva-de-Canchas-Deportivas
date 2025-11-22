<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Court;
use App\Models\CourtType;
use Livewire\Livewire;
use App\Livewire\Admin\Court\Index as CourtIndex;
use App\Livewire\Admin\Court\Create as CourtCreate;
use App\Livewire\Admin\Court\Edit as CourtEdit;

class CourtFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_courts_routes()
    {
        $this->get(route('admin.courts.index'))->assertRedirect(route('login'));
        $this->get(route('admin.courts.create'))->assertRedirect(route('login'));

        $court = Court::factory()->create();
        $this->get(route('admin.courts.edit', $court))->assertRedirect(route('login'));
    }

    public function test_index_shows_courts()
    {
        $authUser = \App\Models\User::factory()->create();
        Court::factory()->create(['nombre' => 'Cancha Test 1']);
        $this->actingAs($authUser);

        Livewire::test(CourtIndex::class)
            ->assertSee('Canchas Deportivas')
            ->assertSee('Cancha Test 1');
    }

    public function test_create_component_validates_and_stores()
    {
        $authUser = \App\Models\User::factory()->create();
        $courtType = CourtType::factory()->create();
        $this->actingAs($authUser);

        // missing fields => validation
        Livewire::test(CourtCreate::class)
            ->call('save')
            ->assertHasErrors(['form.court_type_id', 'form.nombre']);

        // valid data
        Livewire::test(CourtCreate::class)
            ->set('form.court_type_id', $courtType->id)
            ->set('form.nombre', 'Nueva Cancha')
            ->set('form.medidas', '20m x 40m')
            ->set('form.ubicacion', 'Centro')
            ->set('form.disponible', true)
            ->call('save')
            ->assertRedirect(route('admin.courts.index'));

        $this->assertDatabaseHas('courts', ['nombre' => 'Nueva Cancha']);
    }

    public function test_edit_component_updates_court()
    {
        $authUser = \App\Models\User::factory()->create();
        $court = Court::factory()->create(['nombre' => 'Antes']);
        $this->actingAs($authUser);

        Livewire::test(CourtEdit::class, ['court' => $court])
            ->set('form.nombre', 'Despues')
            ->call('save')
            ->assertRedirect(route('admin.courts.index'));

        $this->assertDatabaseHas('courts', ['id' => $court->id, 'nombre' => 'Despues']);
    }

    public function test_index_component_can_delete_court()
    {
        $authUser = \App\Models\User::factory()->create();
        $court = Court::factory()->create();
        $this->actingAs($authUser);

        Livewire::test(CourtIndex::class)
            ->call('deleteCourt', $court->id);

        $this->assertDatabaseMissing('courts', ['id' => $court->id]);
    }
}
