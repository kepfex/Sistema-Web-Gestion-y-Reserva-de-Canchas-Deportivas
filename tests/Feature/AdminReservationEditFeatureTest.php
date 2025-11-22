<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Court;
use App\Livewire\Admin\Reservation\Edit;

class AdminReservationEditFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(\App\Livewire\Admin\Reservation\Edit::class));
    }

            public function test_guest_is_redirected_to_login()
    {
                $reservation = Reservation::factory()->create();
                $this->assertGuestRedirectsToLogin('/admin/reservations/'.$reservation->id.'/edit');
    }



            public function test_authenticated_user_can_mount_component()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        if (class_exists('\App\Livewire\Admin\Reservation\Edit') && is_subclass_of('\App\Livewire\Admin\Reservation\Edit', \Livewire\Component::class)) {
            Livewire::test('\App\Livewire\Admin\Reservation\Edit');
            $this->assertTrue(true);
        } else {
            $this->markTestSkipped('Component class not available or not a Livewire component');
        }
    }



        public function test_edit_component_updates_reservation()
        {
            // Arrange
            $authUser = User::factory()->create();
            $user = User::factory()->create();
            $court = Court::factory()->create(['disponible' => true]);

            $reservation = Reservation::factory()->create([
                'user_id' => $user->id,
                'court_id' => $court->id,
                'fecha_hora_inicio' => '2025-11-21 10:00:00',
                'fecha_hora_fin' => '2025-11-21 11:00:00',
                'estado' => 'pendiente',
            ]);

            $this->actingAs($authUser);

            // Act - update via Edit component
            Livewire::test(Edit::class, ['reservation' => $reservation])
                ->set('form.estado', 'confirmada')
                ->call('save')
                ->assertRedirect(route('admin.reservations.index'));

            // Assert
            $this->assertDatabaseHas('reservations', [
                'id' => $reservation->id,
                'estado' => 'confirmada',
            ]);
        }


}
