<?php

namespace App\Application\Services;

use App\Domain\Entities\Torneo;
use App\Domain\Entities\Jugador;
use App\Domain\Services\CentroDelPartido;
use App\Domain\Repositories\TorneoRepositoryInterface;

class SimuladorDeTorneo
{
    private CentroDelPartido $centroPartido;
    private TorneoRepositoryInterface $torneoRepository;

    public function __construct(CentroDelPartido $centroPartido, TorneoRepositoryInterface $torneoRepository)
    {
        $this->centroPartido = $centroPartido;
        $this->torneoRepository = $torneoRepository;
    }

    /**
     * Simula un torneo de tenis
     *
     * @param Jugador[] $jugadores
     * @param string $tipo 'masculino' o 'femenino'
     * @return Jugador
     */
    public function simular(array $jugadores, string $tipo, \DateTime $fecha, string $lugar): Jugador
    {
        $this->validarCantidadJugadores($jugadores);

        $torneo = new Torneo($jugadores, $tipo, $this->centroPartido, $fecha, $lugar);
        $ganador = $torneo->simular();
        $this->torneoRepository->guardar($torneo);

        return $ganador;
    }

    private function validarCantidadJugadores(array $jugadores): void
    {
        $cantidad = count($jugadores);
        //dd(1);
        if ($cantidad < 2 || !$this->esPotenciaDeDos($cantidad)) {
          //  dd(1);
            throw new \InvalidArgumentException('La cantidad de jugadores debe ser potencia de 2 y mayor que 1.');
        }
    }

    private function esPotenciaDeDos(int $n): bool
    {
        return ($n & ($n - 1)) === 0;
    }
}
