<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pricing extends Model
{
    /** @use HasFactory<\Database\Factories\PricingFactory> */
    use HasFactory;

    protected $fillable = [
        'court_type_id',
        'hora_inicio',
        'hora_fin',
        'precio_por_hora',
        'es_precio_nocturno',
    ];

    // Un precio pertenece a un único tipo de cancha.
    public function courtType(): BelongsTo {
        return $this->belongsTo(CourtType::class);
    }
}
