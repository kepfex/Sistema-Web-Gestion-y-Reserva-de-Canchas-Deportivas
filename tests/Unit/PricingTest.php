<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pricing;
use App\Models\CourtType;

class PricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_pricing_and_courttype_relation()
    {
        // Arrange & Act
        $pricing = Pricing::factory()->create();

        // Assert
        $this->assertInstanceOf(Pricing::class, $pricing);
        $this->assertNotNull($pricing->court_type_id);
        $this->assertTrue($pricing->courtType()->exists());
    }

    public function test_mass_assignment_allows_create_using_fillable()
    {
        // Arrange
        $courtType = CourtType::factory()->create();
        $data = [
            'court_type_id' => $courtType->id,
            'hora_inicio' => '08:00:00',
            'hora_fin' => '10:00:00',
            'precio_por_hora' => 50.00,
            'es_precio_nocturno' => false,
        ];

        // Act
        $pricing = Pricing::create($data);

        // Assert
        $this->assertDatabaseHas('pricings', ['id' => $pricing->id, 'precio_por_hora' => 50.00]);
    }
}
