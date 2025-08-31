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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_hora_inicio')->comment('Fecha y hora de inicio de la reserva');
            $table->dateTime('fecha_hora_fin')->comment('Fecha y hora de finalización de la reserva');
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'completada'])
                  ->default('pendiente')
                  ->comment('Estado actual de la reserva');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('court_id')->constrained('courts')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
