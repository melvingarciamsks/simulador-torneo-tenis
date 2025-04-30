<?php

namespace App\Domain\Entities;
use App\Domain\Services\CentroDelPartido;

class Torneo
{
    private array $jugadores; // array de Jugador
    private string $tipo; // 'masculino' o 'femenino'
    private ?Jugador $ganador = null;
    private CentroDelPartido $centroPartido;
    private \DateTime $fecha;
    private string $lugar;

    public function __construct(
        array $jugadores, 
        string $tipo, 
        CentroDelPartido $centroPartido, 
        \DateTime $fecha,
        string $lugar
    )
    {
        if (!$this->esPotenciaDeDos(count($jugadores))) {
            throw new \InvalidArgumentException('La cantidad de jugadores debe ser una potencia de 2.');
        }

        $this->jugadores = $jugadores;
        $this->tipo = $tipo;
        $this->centroPartido = $centroPartido;
        $this->fecha = $fecha;
        $this->lugar = $lugar;
    }

    public function simular(): Jugador
    {
        $ronda = $this->jugadores;

        while (count($ronda) > 1) {
            $nuevaRonda = [];

            for ($i = 0; $i < count($ronda); $i += 2) {
                $partido = new Partido($ronda[$i], $ronda[$i+1], $this->centroPartido);
                $ganador = $partido->jugar();
                $nuevaRonda[] = $ganador;
            }

            $ronda = $nuevaRonda;
        }

        $this->ganador = $ronda[0];
        return $this->ganador;
    }

    public function getTipo(): string { return $this->tipo; }
    public function getJugadores(): array { return $this->jugadores; }
    public function getFecha(): \DateTime
    {
        return $this->fecha;
    }

    public function getLugar(): string
    {
        return $this->lugar;
    }

    public function getGanador(): ?Jugador
    {
        return $this->ganador;
    }

    private function esPotenciaDeDos(int $n): bool
    {
        return ($n > 0) && (($n & ($n - 1)) === 0);
    }
}
