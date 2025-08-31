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
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre de la cancha (ej. Cancha 1)');
            $table->string('medidas')->nullable()->comment('Dimensiones de la cancha (ej. 20m x 40m)');
            $table->string('ubicacion')->nullable()->comment('Ubicación física');
            $table->boolean('disponible')->default(true)->comment('Indica si la cancha está habilitada para reservas');
            
            $table->foreignId('court_type_id')->constrained('court_types')->comment('ID del tipo de cancha al que pertenece');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};
