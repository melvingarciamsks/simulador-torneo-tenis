<?php

namespace App\Application\DTOs;

class FiltroTorneoDTO
{
    public ?string $fecha;
    public ?string $lugar;
    public ?string $nombreJugador;

    public function __construct(?string $fecha = null, ?string $lugar = null, ?string $nombreJugador = null)
    {
        $this->fecha = $fecha;
        $this->lugar = $lugar;
        $this->nombreJugador = $nombreJugador;
    }
}
