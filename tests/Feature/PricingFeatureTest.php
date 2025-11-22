<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pricing;
use App\Models\CourtType;
use Livewire\Livewire;
use App\Livewire\Admin\Pricing\Index as PricingIndex;
use App\Livewire\Admin\Pricing\Create as PricingCreate;
use App\Livewire\Admin\Pricing\Edit as PricingEdit;

class PricingFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_pricings_routes()
    {
        $this->get(route('admin.pricings.index'))->assertRedirect(route('login'));
        $this->get(route('admin.pricings.create'))->assertRedirect(route('login'));

        $pricing = Pricing::factory()->create();
        $this->get(route('admin.pricings.edit', $pricing))->assertRedirect(route('login'));
    }

    public function test_index_shows_pricings()
    {
        $authUser = \App\Models\User::factory()->create();
        Pricing::factory()->create(['hora_inicio' => '08:00:00']);
        $this->actingAs($authUser);

        Livewire::test(PricingIndex::class)
            ->assertSee('Precios')
            ->assertSee('08:00');
    }

    public function test_create_component_validates_and_stores()
    {
        $authUser = \App\Models\User::factory()->create();
        $courtType = CourtType::factory()->create();
        $this->actingAs($authUser);

        // missing -> errors
        Livewire::test(PricingCreate::class)
            ->call('save')
            ->assertHasErrors(['form.court_type_id', 'form.hora_inicio', 'form.hora_fin']);

        // valid data
        Livewire::test(PricingCreate::class)
            ->set('form.court_type_id', $courtType->id)
            ->set('form.hora_inicio', '08:00')
            ->set('form.hora_fin', '10:00')
            ->set('form.precio_por_hora', 40)
            ->set('form.es_precio_nocturno', false)
            ->call('save')
            ->assertRedirect(route('admin.pricings.index'));

        $this->assertDatabaseHas('pricings', ['precio_por_hora' => 40]);
    }

    public function test_edit_component_updates_pricing()
    {
        $authUser = \App\Models\User::factory()->create();
        $pricing = Pricing::factory()->create(['precio_por_hora' => 30]);
        $this->actingAs($authUser);

        Livewire::test(PricingEdit::class, ['pricing' => $pricing])
            ->set('form.hora_inicio', '08:00')
            ->set('form.hora_fin', '09:00')
            ->set('form.precio_por_hora', 55)
            ->call('save')
            ->assertRedirect(route('admin.pricings.index'));

        $this->assertDatabaseHas('pricings', ['id' => $pricing->id, 'precio_por_hora' => 55]);
    }

    public function test_index_component_can_delete_pricing()
    {
        $authUser = \App\Models\User::factory()->create();
        $pricing = Pricing::factory()->create();
        $this->actingAs($authUser);

        Livewire::test(PricingIndex::class)
            ->call('deletePricing', $pricing->id);

        $this->assertDatabaseMissing('pricings', ['id' => $pricing->id]);
    }
}
