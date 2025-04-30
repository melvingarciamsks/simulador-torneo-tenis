<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Services\SimuladorDeTorneo;
use App\Application\Services\ConsultarTorneos;
use App\Domain\Entities\JugadorFemenino;
use App\Domain\Entities\JugadorMasculino;
use App\Application\DTOs\FiltroTorneoDTO;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;


class TorneoController extends BaseController
{

    /**
     * @OA\Schema(
     *     schema="Torneo",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="tipo", type="string", example="masculino"),
     *     @OA\Property(property="fecha", type="string", format="date", example="2025-10-01"),
     *     @OA\Property(property="lugar", type="string", example="Buenos Aires"),
     *     @OA\Property(
     *         property="jugadores",
     *         type="array",
     *         @OA\Items(
     *             type="object",
     *             @OA\Property(property="nombre", type="string", example="Pedro Perez"),
     *             @OA\Property(property="nivelHabilidad", type="integer", example=90)
     *         )
     *     ),
     *     @OA\Property(
     *         property="ganador",
     *         type="object",
     *         @OA\Property(property="nombre", type="string", example="Pedro Perez"),
     *         @OA\Property(property="nivelHabilidad", type="integer", example=90)
     *     )
     * )
     */

    private SimuladorDeTorneo $simuladorDeTorneo;

    public function __construct(SimuladorDeTorneo $simuladorDeTorneo)
    {
        $this->simuladorDeTorneo = $simuladorDeTorneo;
    }

    /**
     * @OA\Post(
     *     path="/api/torneos/simular",
     *     summary="Simula un torneo de tenis",
     *     tags={"Torneos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tipo", "jugadores"},
     *             @OA\Property(property="tipo", type="string", enum={"masculino", "femenino"}),
     *             @OA\Property(property="fecha", type="string", format="date"),
     *             @OA\Property(property="lugar", type="string"),
     *             @OA\Property(
     *                 property="jugadores",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"nombre", "nivelHabilidad"},
     *                     @OA\Property(property="nombre", type="string"),
     *                     @OA\Property(property="nivelHabilidad", type="integer"),
     *                     @OA\Property(property="fuerza", type="integer"),
     *                     @OA\Property(property="velocidad", type="integer"),
     *                     @OA\Property(property="tiempoReaccion", type="integer")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Ganador del torneo")
     * )
     */
    public function simular(Request $request)
    {
     
        try {
            $data = $request->validate([
                'tipo' => 'required|in:masculino,femenino',
                'fecha' => 'required|date',
                'lugar' => 'required|string|max:255',
                'jugadores' => 'required|array|min:1',
                'jugadores.*.nombre' => 'required|string',
                'jugadores.*.nivelHabilidad' => 'required|integer|min:0|max:100',
                'jugadores.*.fuerza' => 'nullable|integer|min:0',  // Solo para masculinos
                'jugadores.*.velocidad' => 'nullable|integer|min:0',  // Solo para masculinos
                'jugadores.*.tiempoReaccion' => 'nullable|integer|min:0',  // Solo para femeninos
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $e->errors(), // ← Aquí están los detalles campo por campo
            ], 422);
        }
        $tipo = $data['tipo'];
        $jugadoresInput = $data['jugadores'];
        $lugar = $data['lugar'];
        $fecha = new \DateTime($data['fecha']);
        $jugadores = [];

        //dd(88);

        foreach ($jugadoresInput as $jugadorData) {
            if ($tipo === 'masculino') {
                if (!isset($jugadorData['fuerza']) || !isset($jugadorData['velocidad'])) {
                    return response()->json(['error' => 'Fuerza y velocidad requeridos para jugadores masculinos'], 422);
                }
                $jugadores[] = new JugadorMasculino(
                    $jugadorData['nombre'],
                    $jugadorData['nivelHabilidad'],
                    $jugadorData['fuerza'],
                    $jugadorData['velocidad']
                );
            } else {
                if (!isset($jugadorData['tiempoReaccion'])) {
                    return response()->json(['error' => 'Tiempo de reacción requerido para jugadores femeninos'], 422);
                }
                $jugadores[] = new JugadorFemenino(
                    $jugadorData['nombre'],
                    $jugadorData['nivelHabilidad'],
                    $jugadorData['tiempoReaccion']
                );
            }
        }
        try {
            //code...
             $ganador = $this->simuladorDeTorneo->simular($jugadores, $tipo, $fecha, $lugar);
             return response()->json([
                'ganador' => [
                    'nombre' => $ganador->getNombre(),
                    'nivelHabilidad' => $ganador->getNivelHabilidad(),
                    'atributos' => $this->obtenerAtributosEspeciales($ganador),
                ]
        ]);
        } catch (\Throwable $th) {
            //throw $th;
            //dd($th);
            return response()->json(['error' => $th->getMessage()], 422);
        }
       

        
    }

    /**
     * @OA\Get(
     *     path="/api/torneos",
     *     summary="Buscar torneos",
     *     tags={"Torneos"},
     *     @OA\Parameter(
     *         name="fecha",
     *         in="query",
     *         description="Filtrar por fecha del torneo (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="lugar",
     *         in="query",
     *         description="Filtrar por lugar del torneo",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="nombreJugador",
     *         in="query",
     *         description="Filtrar por nombre del jugador",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de torneos filtrados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Torneo")
     *         )
     *     )
     * )
     */

    public function index(Request $request, ConsultarTorneos $consultarTorneos)
    {
        $filtros = new FiltroTorneoDTO(
            $request->query('fecha'),
            $request->query('lugar'),
            $request->query('nombreJugador')
        );

        $torneos = $consultarTorneos->ejecutar($filtros);

        return response()->json($torneos);
        
    }

    private function obtenerAtributosEspeciales($jugador): array
    {
        if ($jugador instanceof JugadorMasculino) {
            return [
                'fuerza' => $jugador->getFuerza(),
                'velocidad' => $jugador->getVelocidad(),
            ];
        }

        if ($jugador instanceof JugadorFemenino) {
            return [
                'tiempoReaccion' => $jugador->getTiempoReaccion(),
            ];
        }

        return [];
    }
}
