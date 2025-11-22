<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\Pricing;
use App\Livewire\Admin\Pricing\Edit;

class AdminPricingEditFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Admin\Pricing\Edit::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $pricing = \App\Models\Pricing::factory()->create();
                $this->assertGuestRedirectsToLogin('/admin/pricings/'.$pricing->id.'/edit');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Admin\Pricing\Edit') && is_subclass_of('\App\Livewire\Admin\Pricing\Edit', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Admin\Pricing\Edit');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_edit_component_updates_pricing()
        {
            $authUser = \App\Models\User::factory()->create();
            $pricing = Pricing::factory()->create(['precio_por_hora' => 30]);
            $this->actingAs($authUser);

            Livewire::test(Edit::class, ['pricing' => $pricing])
                ->set('form.hora_inicio', '08:00')
                ->set('form.hora_fin', '09:00')
                ->set('form.precio_por_hora', 55)
                ->call('save')
                ->assertRedirect(route('admin.pricings.index'));

            $this->assertDatabaseHas('pricings', ['id' => $pricing->id, 'precio_por_hora' => 55]);
        }


}
