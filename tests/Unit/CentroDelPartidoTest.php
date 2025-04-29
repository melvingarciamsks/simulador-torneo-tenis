<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Domain\Entities\JugadorMasculino;
use App\Domain\Services\CentroDelPartido;

class CentroDelPartidoTest extends TestCase
{
    public function testJugarDevuelveUnGanador()
    {
        $jugador1 = new JugadorMasculino('Jugador 1', 80, 70, 60);
        $jugador2 = new JugadorMasculino('Jugador 2', 75, 65, 55);

        $motor = new CentroDelPartido();
        $ganador = $motor->jugar($jugador1, $jugador2);

        $this->assertContains($ganador, [$jugador1, $jugador2]);
    }
}
