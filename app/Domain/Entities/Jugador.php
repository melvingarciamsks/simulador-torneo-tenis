<?php

namespace App\Domain\Entities;

abstract class Jugador
{
    protected string $nombre;
    protected int $nivelHabilidad; // 0-100

    public function __construct(string $nombre, int $nivelHabilidad)
    {
        $this->nombre = $nombre;
        $this->nivelHabilidad = $nivelHabilidad;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getNivelHabilidad(): int
    {
        return $this->nivelHabilidad;
    }

    abstract public function calcularPuntaje(): int;
}
