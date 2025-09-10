<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Court extends Model
{
    /** @use HasFactory<\Database\Factories\CourtFactory> */
    use HasFactory;

    protected $fillable = [
        'court_type_id',
        'nombre',
        'medidas',
        'ubicacion',
        'disponible',
    ];

    // Una cancha pertenece a un único tipo de cancha.
    public function courtType(): BelongsTo {
        return $this->belongsTo(CourtType::class);
    }

    // Una cancha puede tener varias reservas.
    public function reservations():HasMany {
        return $this->hasMany(Reservation::class);
    }

    // Una cancha puede tener varios horarios.
    public function schedules(): HasMany {
        return $this->hasMany(Schedule::class);
    }
}
