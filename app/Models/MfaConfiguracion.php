<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MfaConfiguracion extends Model
{
    protected $table = 'mfa_configuracion';

    protected $fillable = [
        'usuario_id',
        'google2fa_secret',
        'activado',
    ];

    protected $casts = [
        'activado' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
