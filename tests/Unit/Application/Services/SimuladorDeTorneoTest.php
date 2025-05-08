<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Application\Services\SimuladorDeTorneo;
use App\Domain\Entities\JugadorMasculino;
use App\Domain\Services\CentroDelPartido;
use App\Domain\Repositories\TorneoRepositoryInterface;

class SimuladorDeTorneoTest extends TestCase
{
    public function testSimuladorDeTorneoDevuelveGanador()
    {
        // Arrange
        $repo = $this->createMock(TorneoRepositoryInterface::class);
        $repo->expects($this->once())->method('guardar');
        $motor = new CentroDelPartido();
        $simulador = new SimuladorDeTorneo($motor, $repo);

        $jugadores = [
            new JugadorMasculino('Jugador 1', 80, 70, 60),
            new JugadorMasculino('Jugador 2', 85, 75, 65),
            new JugadorMasculino('Jugador 3', 90, 80, 70),
            new JugadorMasculino('Jugador 4', 95, 85, 75),
        ];

        // Act
        $ganador = $simulador->simular($jugadores, 'masculino', new \DateTime(), 'Buenos Aires');

        // Assert
        $this->assertInstanceOf(JugadorMasculino::class, $ganador);
        $this->assertContains($ganador, $jugadores);
    }

    public function testSimuladorDeTorneoLanzaExcepcionSiCantidadIncorrecta()
    {
        // Arrange
        $this->expectException(\InvalidArgumentException::class);

        $repo = $this->createMock(TorneoRepositoryInterface::class);
        //$repo->expects($this->once())->method('guardar');
        $motor = new CentroDelPartido();
        $simulador = new SimuladorDeTorneo($motor, $repo);

        $jugadores = [
            new JugadorMasculino('Jugador 1', 80, 70, 60),
            new JugadorMasculino('Jugador 2', 85, 75, 65),
            new JugadorMasculino('Jugador 3', 90, 80, 70),
        ];

        // Act
        $simulador->simular($jugadores, 'masculino', new \DateTime(), 'Buenos Aires');
    }
}
