<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Torneo;
use App\Domain\Entities\JugadorMasculino;
use App\Domain\Entities\JugadorFemenino;
use App\Domain\Entities\SimuladorTorneo;

class TorneoSeeder extends Seeder
{
    public function run(): void
    {
        $torneos = [
            [
                'tipo' => 'masculino',
                'fecha' => '2025-04-01',
                'lugar' => 'Buenos Aires',
                'jugadores' => ([
                    ['nombre' => 'Carlos Gómez', 'nivelHabilidad' => 85, 'fuerza' => 70, 'velocidad' => 75],
                    ['nombre' => 'Pedro Sánchez', 'nivelHabilidad' => 80, 'fuerza' => 68, 'velocidad' => 72],
                    ['nombre' => 'Luis Pérez', 'nivelHabilidad' => 77, 'fuerza' => 65, 'velocidad' => 78],
                    ['nombre' => 'Jorge Díaz', 'nivelHabilidad' => 83, 'fuerza' => 72, 'velocidad' => 70],
                    ['nombre' => 'Andrés Molina', 'nivelHabilidad' => 88, 'fuerza' => 74, 'velocidad' => 76],
                    ['nombre' => 'Sergio Ramos', 'nivelHabilidad' => 79, 'fuerza' => 67, 'velocidad' => 74],
                    ['nombre' => 'Mario Vargas', 'nivelHabilidad' => 81, 'fuerza' => 69, 'velocidad' => 73],
                    ['nombre' => 'Ricardo Rojas', 'nivelHabilidad' => 84, 'fuerza' => 71, 'velocidad' => 72],
                ]),
                'ganador' =>  ['nombre' => 'Ricardo Rojas', 'nivelHabilidad' => 84, 'fuerza' => 71, 'velocidad' => 72]
            ],
            [
                'tipo' => 'femenino',
                'fecha' => '2025-03-15',
                'lugar' => 'Santiago',
                'jugadores' => ([
                    ['nombre' => 'Ana López', 'nivelHabilidad' => 90, 'tiempoReaccion' => 65],
                    ['nombre' => 'Lucía Torres', 'nivelHabilidad' => 82, 'tiempoReaccion' => 70],
                    ['nombre' => 'Carla Pérez', 'nivelHabilidad' => 78, 'tiempoReaccion' => 68],
                    ['nombre' => 'Sofía Gómez', 'nivelHabilidad' => 85, 'tiempoReaccion' => 72],
                    ['nombre' => 'Daniela Ruiz', 'nivelHabilidad' => 79, 'tiempoReaccion' => 67],
                    ['nombre' => 'Valentina Soto', 'nivelHabilidad' => 83, 'tiempoReaccion' => 69],
                    ['nombre' => 'Fernanda Díaz', 'nivelHabilidad' => 81, 'tiempoReaccion' => 66],
                    ['nombre' => 'Gabriela Núñez', 'nivelHabilidad' => 86, 'tiempoReaccion' => 73],
                ]),
                'ganador' => ['nombre' => 'Gabriela Núñez', 'nivelHabilidad' => 86, 'tiempoReaccion' => 73]
            ],
            [
                'tipo' => 'masculino',
                'fecha' => '2025-02-05',
                'lugar' => 'Lima',
                'jugadores' => ([
                    ['nombre' => 'Juan Pérez', 'nivelHabilidad' => 78, 'fuerza' => 60, 'velocidad' => 80],
                    ['nombre' => 'Esteban Ramírez', 'nivelHabilidad' => 88, 'fuerza' => 74, 'velocidad' => 70],
                    ['nombre' => 'Miguel Sánchez', 'nivelHabilidad' => 82, 'fuerza' => 66, 'velocidad' => 77],
                    ['nombre' => 'Cristian Lara', 'nivelHabilidad' => 84, 'fuerza' => 68, 'velocidad' => 76],
                    ['nombre' => 'Diego León', 'nivelHabilidad' => 79, 'fuerza' => 65, 'velocidad' => 74],
                    ['nombre' => 'Héctor Moreno', 'nivelHabilidad' => 81, 'fuerza' => 70, 'velocidad' => 75],
                    ['nombre' => 'Nicolás Figueroa', 'nivelHabilidad' => 85, 'fuerza' => 73, 'velocidad' => 71],
                    ['nombre' => 'Oscar Beltrán', 'nivelHabilidad' => 80, 'fuerza' => 69, 'velocidad' => 72],
                ]),
                'ganador' => ['nombre' => 'Oscar Beltrán', 'nivelHabilidad' => 80, 'fuerza' => 69, 'velocidad' => 72]
            ],
            [
                'tipo' => 'femenino',
                'fecha' => '2025-01-21',
                'lugar' => 'Montevideo',
                'jugadores' => ([
                    ['nombre' => 'Camila Suárez', 'nivelHabilidad' => 76, 'tiempoReaccion' => 82],
                    ['nombre' => 'Martina Ríos', 'nivelHabilidad' => 84, 'tiempoReaccion' => 77],
                    ['nombre' => 'Verónica López', 'nivelHabilidad' => 80, 'tiempoReaccion' => 75],
                    ['nombre' => 'María José Pérez', 'nivelHabilidad' => 85, 'tiempoReaccion' => 78],
                    ['nombre' => 'Laura Salas', 'nivelHabilidad' => 79, 'tiempoReaccion' => 74],
                    ['nombre' => 'Paula Martínez', 'nivelHabilidad' => 81, 'tiempoReaccion' => 76],
                    ['nombre' => 'Isabella Herrera', 'nivelHabilidad' => 83, 'tiempoReaccion' => 73],
                    ['nombre' => 'Natalia Vargas', 'nivelHabilidad' => 82, 'tiempoReaccion' => 71],
                ]),
                'ganador' => ['nombre' => 'Natalia Vargas', 'nivelHabilidad' => 82, 'tiempoReaccion' => 71]
            ],
        ];

        foreach ($torneos as $torneo) {
            Torneo::create($torneo);
        }
    }
}
