<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;
    protected $fillable = [
        'fecha_hora_inicio',
        'fecha_hora_fin',
        'estado',
        'user_id',
        'court_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_hora_inicio' => 'datetime',
        'fecha_hora_fin' => 'datetime',
        'estado' => 'string',
    ];

    /**
     * Obtiene el usuario propietario de la reserva.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene la cancha para la cual es la reserva.
     */
    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }
}
