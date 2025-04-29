<?php

namespace App\Domain\Entities;

class JugadorMasculino extends Jugador
{
    private int $fuerza;
    private int $velocidad;

    public function __construct(string $nombre, int $nivelHabilidad, int $fuerza, int $velocidad)
    {
        parent::__construct($nombre, $nivelHabilidad);
        $this->fuerza = $fuerza;
        $this->velocidad = $velocidad;
    }

    public function calcularPuntaje(): int
    {
        return $this->nivelHabilidad + $this->fuerza + $this->velocidad;
    }

    public function getFuerza(): int
    {
        return $this->fuerza;
    }

    public function getVelocidad(): int
    {
        return $this->velocidad;
    }
}
