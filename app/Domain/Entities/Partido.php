<?php

namespace App\Domain\Entities;

use App\Domain\Services\CentroDelPartido;

class Partido
{
    private Jugador $jugador1;
    private Jugador $jugador2;
    private CentroDelPartido $centroPartido;

    public function __construct(Jugador $jugador1, Jugador $jugador2, CentroDelPartido $centroPartido)
    {
        $this->jugador1 = $jugador1;
        $this->jugador2 = $jugador2;
        $this->centroPartido = $centroPartido;
    }

    public function jugar(): Jugador
    {
        return $this->centroPartido->jugar($this->jugador1, $this->jugador2);
    }

}
