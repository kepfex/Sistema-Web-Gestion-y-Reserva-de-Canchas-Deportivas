<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\Pricing;
use App\Models\CourtType;
use App\Livewire\Admin\Pricing\Create;

class AdminPricingCreateFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Admin\Pricing\Create::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $this->assertGuestRedirectsToLogin('/admin/pricings/create');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Admin\Pricing\Create') && is_subclass_of('\App\Livewire\Admin\Pricing\Create', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Admin\Pricing\Create');
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

            // missing -> errors
            Livewire::test(Create::class)
                ->call('save')
                ->assertHasErrors(['form.court_type_id', 'form.hora_inicio', 'form.hora_fin']);

            // valid data
            Livewire::test(Create::class)
                ->set('form.court_type_id', $courtType->id)
                ->set('form.hora_inicio', '08:00')
                ->set('form.hora_fin', '10:00')
                ->set('form.precio_por_hora', 40)
                ->set('form.es_precio_nocturno', false)
                ->call('save')
                ->assertRedirect(route('admin.pricings.index'));

            $this->assertDatabaseHas('pricings', ['precio_por_hora' => 40]);
        }


}
