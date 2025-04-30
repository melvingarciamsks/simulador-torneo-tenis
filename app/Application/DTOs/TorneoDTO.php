<?php
namespace App\Application\DTOs;

class TorneoDTO
{
    public static function fromModel($torneo): array
    {
        //dd($torneo);
        return [
            'id' => $torneo->id,
            'tipo' => $torneo->tipo,
            'fecha' => $torneo->fecha->format('Y-m-d'),
            'lugar' => $torneo->lugar,
            'jugadores' => $torneo->jugadores,
            'ganador' => $torneo->ganador,
        ];
    }
}
