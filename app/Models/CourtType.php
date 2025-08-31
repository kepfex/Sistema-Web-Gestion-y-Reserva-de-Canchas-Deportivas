<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourtType extends Model
{
    /** @use HasFactory<\Database\Factories\CourtTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Un tipo de cancha puede tener varias canchas
    public function courts(): HasMany{ 
        return $this->hasMany(Court::class);
    }

    // Un tipo de cancha puede tener diferentes precios.
    public function pricing(): hasMany {
        return $this->hasMany(Pricing::class);
    }
}
