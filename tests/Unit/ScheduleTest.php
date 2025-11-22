<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Schedule;
use App\Models\Court;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_schedule_and_court_relation()
    {
        // Arrange & Act
        $schedule = Schedule::factory()->create();

        // Assert
        $this->assertInstanceOf(Schedule::class, $schedule);
        $this->assertNotNull($schedule->court_id);
        $this->assertTrue($schedule->court()->exists());
    }

    public function test_mass_assignment_allows_create_using_fillable()
    {
        // Arrange
        $court = Court::factory()->create();
        $data = [
            'court_id' => $court->id,
            'dia_de_la_semana' => 'lunes',
            'hora_apertura' => '08:00:00',
            'hora_cierre' => '10:00:00',
        ];

        // Act
        $schedule = Schedule::create($data);

        // Assert
        $this->assertDatabaseHas('schedules', ['id' => $schedule->id, 'dia_de_la_semana' => 'lunes']);
    }
}
