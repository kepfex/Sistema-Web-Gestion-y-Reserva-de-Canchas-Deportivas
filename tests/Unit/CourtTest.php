<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Court;
use App\Models\CourtType;
use App\Models\Reservation;
use App\Models\Schedule;

class CourtTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_court_and_has_courttype_relation()
    {
        // Arrange & Act
        $court = Court::factory()->create();

        // Assert
        $this->assertInstanceOf(Court::class, $court);
        $this->assertNotNull($court->court_type_id);
        $this->assertTrue($court->relationLoaded('courtType') || $court->courtType()->exists());
    }

    public function test_court_has_many_reservations_and_schedules()
    {
        // Arrange
        $court = Court::factory()->create();
        $reservation = Reservation::factory()->create(['court_id' => $court->id]);
        $schedule = Schedule::factory()->create(['court_id' => $court->id]);

        // Act & Assert
        $this->assertEquals(1, $court->reservations()->count());
        $this->assertEquals(1, $court->schedules()->count());
        $this->assertEquals($reservation->id, $court->reservations()->first()->id);
        $this->assertEquals($schedule->id, $court->schedules()->first()->id);
    }

    public function test_mass_assignment_on_court()
    {
        // Arrange
        $courtType = CourtType::factory()->create();
        $data = [
            'court_type_id' => $courtType->id,
            'nombre' => 'Cancha Test',
            'medidas' => '20m x 40m',
            'ubicacion' => 'Centro Deportivo',
            'disponible' => true,
        ];

        // Act
        $court = Court::create($data);

        // Assert
        $this->assertDatabaseHas('courts', ['id' => $court->id, 'nombre' => 'Cancha Test']);
    }
}
