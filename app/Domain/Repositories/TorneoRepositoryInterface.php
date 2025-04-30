<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Torneo;
use App\Application\DTOs\FiltroTorneoDTO;

interface TorneoRepositoryInterface
{
    public function guardar(Torneo $torneo): void;

    public function buscarPorFiltros(FiltroTorneoDTO $filtros): array;
}