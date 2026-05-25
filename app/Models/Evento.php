<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'lugar',
        'categoria',
        'imagen',
        'usuario_id',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    /**
     * Get the user that organized/created the event.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
