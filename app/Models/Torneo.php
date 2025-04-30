<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    protected $fillable = ['tipo', 'jugadores', 'ganador', 'fecha', 'lugar'];

    protected $casts = [
        'jugadores' => 'array',
        'ganador' => 'array',
        'fecha' => 'date'
    ];
}
