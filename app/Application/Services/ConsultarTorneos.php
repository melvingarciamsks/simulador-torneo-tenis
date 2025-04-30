<?php
namespace App\Application\Services;

use App\Application\DTOs\FiltroTorneoDTO;
use App\Domain\Repositories\TorneoRepositoryInterface;

class ConsultarTorneos
{
    private TorneoRepositoryInterface $torneoRepository;

    public function __construct(TorneoRepositoryInterface $torneoRepository)
    {
        $this->torneoRepository = $torneoRepository;
    }

    public function ejecutar(FiltroTorneoDTO $filtros): array
    {
        return $this->torneoRepository->buscarPorFiltros($filtros);
    }
}
