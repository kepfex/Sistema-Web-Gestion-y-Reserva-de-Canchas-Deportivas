<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Court;
use App\Livewire\Admin\Reservation\Create;

class AdminReservationCreateFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Admin\Reservation\Create::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $this->assertGuestRedirectsToLogin('/admin/reservations/create');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Admin\Reservation\Create') && is_subclass_of('\App\Livewire\Admin\Reservation\Create', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Admin\Reservation\Create');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_create_component_shows_validation_errors_and_can_store_reservation()
        {
            // Arrange
            $authUser = User::factory()->create();
            $user = User::factory()->create();
            $court = Court::factory()->create(['disponible' => true]);

            $this->actingAs($authUser);

            // Act & Assert - missing fields produce validation errors
            Livewire::test(Create::class)
                ->call('save')
                ->assertHasErrors([
                    'form.user_id',
                    'form.court_id',
                    'form.fecha_hora_inicio',
                    'form.fecha_hora_fin',
                ]);

            // Act - submit valid data
            Livewire::test(Create::class)
                ->set('form.user_id', $user->id)
                ->set('form.court_id', $court->id)
                ->set('form.fecha_hora_inicio', '2025-11-21T10:00')
                ->set('form.fecha_hora_fin', '2025-11-21T11:00')
                ->set('form.estado', 'pendiente')
                ->call('save')
                ->assertRedirect(route('admin.reservations.index'));

            // Assert - reservation stored
            $this->assertDatabaseHas('reservations', [
                'user_id' => $user->id,
                'court_id' => $court->id,
                'estado' => 'pendiente',
            ]);
        }


}
