<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Court;
use App\Models\Reservation;
use Livewire\Livewire;
use App\Livewire\Admin\Reservation\Index as ReservationIndex;
use App\Livewire\Admin\Reservation\Create as ReservationCreate;
use App\Livewire\Admin\Reservation\Edit as ReservationEdit;

class ReservationFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_reservations_routes()
    {
        // Arrange - no auth

        // Act & Assert
        $this->get(route('admin.reservations.index'))->assertRedirect(route('login'));
        $this->get(route('admin.reservations.create'))->assertRedirect(route('login'));

        // For edit route we need an id param — create a reservation with required relations
        $user = User::factory()->create();
        $court = Court::factory()->create();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'court_id' => $court->id,
        ]);

        $this->get(route('admin.reservations.edit', $reservation))->assertRedirect(route('login'));
    }

    public function test_index_shows_reservations_with_user_and_court()
    {
        // Arrange
        $authUser = User::factory()->create();
        $user = User::factory()->create(['name' => 'Cliente Prueba']);
        $court = Court::factory()->create(['nombre' => 'Cancha 1']);

        Reservation::factory()->create([
            'user_id' => $user->id,
            'court_id' => $court->id,
            'estado' => 'pendiente',
        ]);

        // Act & Assert - mount Livewire component as authenticated user
        $this->actingAs($authUser);

        Livewire::test(ReservationIndex::class)
            ->assertSee('Reservaciones')
            ->assertSee('Cliente Prueba')
            ->assertSee('Cancha 1');
    }

    public function test_create_component_shows_validation_errors_and_can_store_reservation()
    {
        // Arrange
        $authUser = User::factory()->create();
        $user = User::factory()->create();
        $court = Court::factory()->create(['disponible' => true]);

        $this->actingAs($authUser);

        // Act & Assert - missing fields produce validation errors
        Livewire::test(ReservationCreate::class)
            ->call('save')
            ->assertHasErrors([
                'form.user_id',
                'form.court_id',
                'form.fecha_hora_inicio',
                'form.fecha_hora_fin',
            ]);

        // Act - submit valid data
        Livewire::test(ReservationCreate::class)
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
        Livewire::test(ReservationEdit::class, ['reservation' => $reservation])
            ->set('form.estado', 'confirmada')
            ->call('save')
            ->assertRedirect(route('admin.reservations.index'));

        // Assert
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'estado' => 'confirmada',
        ]);
    }

    public function test_index_component_can_delete_reservation()
    {
        // Arrange
        $authUser = User::factory()->create();
        $user = User::factory()->create();
        $court = Court::factory()->create();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'court_id' => $court->id,
        ]);

        $this->actingAs($authUser);

        // Act
        Livewire::test(ReservationIndex::class)
            ->call('deleteReservation', $reservation->id);

        // Assert
        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
        ]);
    }
}
