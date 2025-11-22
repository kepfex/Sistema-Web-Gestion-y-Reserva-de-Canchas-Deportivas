<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Court;
use Illuminate\Support\Carbon;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_reservation_and_relations_are_eager_loaded()
    {
        // Arrange
        $user = User::factory()->create();
        $court = Court::factory()->create();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'court_id' => $court->id,
            'fecha_hora_inicio' => '2025-11-20 10:00:00',
            'fecha_hora_fin' => '2025-11-20 11:00:00',
            'estado' => 'pendiente',
        ]);

        // Act
        $found = Reservation::with(['user', 'court'])->find($reservation->id);

        // Assert
        $this->assertInstanceOf(Reservation::class, $found);
        $this->assertTrue($found->relationLoaded('user'));
        $this->assertTrue($found->relationLoaded('court'));
        $this->assertEquals($user->id, $found->user->id);
        $this->assertEquals($court->id, $found->court->id);
    }

    public function test_fecha_hora_casts_to_carbon_instances()
    {
        // Arrange
        $user = User::factory()->create();
        $court = Court::factory()->create();

        // Act
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'court_id' => $court->id,
            'fecha_hora_inicio' => '2025-11-20 10:00:00',
            'fecha_hora_fin' => '2025-11-20 11:00:00',
            'estado' => 'confirmada',
        ]);

        // Assert
        $this->assertInstanceOf(Carbon::class, $reservation->fecha_hora_inicio);
        $this->assertInstanceOf(Carbon::class, $reservation->fecha_hora_fin);
        $this->assertEquals('2025-11-20 10:00:00', $reservation->fecha_hora_inicio->format('Y-m-d H:i:s'));
    }

    public function test_mass_assignment_allows_create_using_fillable()
    {
        // Arrange
        $user = User::factory()->create();
        $court = Court::factory()->create();

        $data = [
            'user_id' => $user->id,
            'court_id' => $court->id,
            'fecha_hora_inicio' => now()->addDay()->format('Y-m-d H:i:s'),
            'fecha_hora_fin' => now()->addDay()->addHour()->format('Y-m-d H:i:s'),
            'estado' => 'pendiente',
        ];

        // Act
        $reservation = Reservation::create($data);

        // Assert
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'user_id' => $user->id,
            'court_id' => $court->id,
        ]);
    }
}
