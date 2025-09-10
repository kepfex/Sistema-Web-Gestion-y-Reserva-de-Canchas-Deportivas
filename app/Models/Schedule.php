<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'court_id',
        'dia_de_la_semana',
        'hora_apertura',
        'hora_cierre',
    ];

    // Un horario pertenece a una única cancha.
    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }
}
