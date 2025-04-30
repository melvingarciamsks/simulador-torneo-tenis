<?php
namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Jugador;
use App\Domain\Entities\JugadorMasculino;
use App\Domain\Entities\JugadorFemenino;
use App\Domain\Entities\Torneo as TorneoEntidad;
use App\Domain\Repositories\TorneoRepositoryInterface;
use App\Models\Torneo;
use App\Application\DTOs\FiltroTorneoDTO;

class TorneoEloquentRepository implements TorneoRepositoryInterface
{
    public function guardar(TorneoEntidad $torneo): void
    {

        $ganador = $torneo->getGanador();
      //  dd($ganador);
       // dd(json_encode($this->serializarJugador($ganador)));
        
        Torneo::create([
            'tipo' => $torneo->getTipo(),
            'fecha' => $torneo->getFecha()->format('Y-m-d'),
            'lugar' => $torneo->getLugar(),
            //'jugadores' => $torneo->getJugadores(),
            'jugadores' => (array_map(fn($j) => $this->serializarJugador($j), $torneo->getJugadores())),
            'ganador' => ($this->serializarJugador($ganador))
        ]);
        
    }

    public function buscarPorFiltros(FiltroTorneoDTO $filtros): array
    {
        $query = Torneo::query();

        if ($filtros->fecha) {
            $query->whereDate('fecha', $filtros->fecha);
        }

        if ($filtros->lugar) {
            $query->where('lugar', 'like', '%' . $filtros->lugar . '%');
        }

        if ($filtros->nombreJugador) {
            $query->whereJsonContains('jugadores', [['nombre' => $filtros->nombreJugador]]);
        }

        $query->select('id', 'fecha', 'lugar', 'jugadores', 'ganador');

        return $query->get()->toArray();
    }

    private function serializarJugador(Jugador $jugador): array
    {
        $base = [
            'nombre' => $jugador->getNombre(),
            'nivelHabilidad' => $jugador->getNivelHabilidad(),
            //'tipo' => get_class($jugador), // Para reconstruir luego si querés
        ];

        if ($jugador instanceof JugadorMasculino) {
            $base['fuerza'] = $jugador->getFuerza();
            $base['velocidad'] = $jugador->getVelocidad();
        } elseif ($jugador instanceof JugadorFemenino) {
            $base['tiempoReaccion'] = $jugador->getTiempoReaccion();
        }

        return $base;
    }
}