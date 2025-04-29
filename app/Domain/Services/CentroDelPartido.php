<?php

namespace App\Domain\Services;

use App\Domain\Entities\Jugador;

class CentroDelPartido
{
    public function jugar(Jugador $jugador1, Jugador $jugador2): Jugador
    {
        $puntaje1 = $this->calcularPuntajeConSuerte($jugador1);
        $puntaje2 = $this->calcularPuntajeConSuerte($jugador2);

        if ($puntaje1 === $puntaje2) {
            // Desempatar: puede ser simplemente elegir al azar o agregar mini lógica
            return $this->desempatar($jugador1, $jugador2);
        }

        return ($puntaje1 > $puntaje2) ? $jugador1 : $jugador2;
    }

    private function calcularPuntajeConSuerte(Jugador $jugador): int
    {
        $puntajeBase = $jugador->calcularPuntaje();
        $suerte = random_int(-10, 10); // Variación de la suerte
        return $puntajeBase + $suerte;
    }

    private function desempatar(Jugador $jugador1, Jugador $jugador2): Jugador
    {
        // En caso de empate, elige al azar
        return (random_int(0, 1) === 0) ? $jugador1 : $jugador2;
    }
}
