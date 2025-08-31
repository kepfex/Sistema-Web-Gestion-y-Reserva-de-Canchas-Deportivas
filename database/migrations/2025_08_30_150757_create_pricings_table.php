<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->time('hora_inicio')->comment('Hora de inicio de la franja de precio');
            $table->time('hora_fin')->comment('Hora de fin de la franja de precio');
            $table->decimal('precio_por_hora', 8, 2)->comment('Precio por hora para esta franja');
            $table->boolean('es_precio_nocturno')->default(false)->comment('Verdadero si el precio es por la noche');
            
            $table->foreignId('court_type_id')->constrained('court_types')->onDelete('cascade');;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricings');
    }
};
