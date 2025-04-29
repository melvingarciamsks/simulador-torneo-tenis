<?php

namespace App\Domain\Entities;

class JugadorFemenino extends Jugador
{
    private int $tiempoReaccion;

    public function __construct(string $nombre, int $nivelHabilidad, int $tiempoReaccion)
    {
        parent::__construct($nombre, $nivelHabilidad);
        $this->tiempoReaccion = $tiempoReaccion;
    }

    public function calcularPuntaje(): int
    {
        return $this->nivelHabilidad + $this->tiempoReaccion;
    }

    public function getTiempoReaccion(): int 
    {
        return $this->tiempoReaccion;
    }
}
