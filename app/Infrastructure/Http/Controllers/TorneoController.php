<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Services\SimuladorDeTorneo;
use App\Domain\Entities\JugadorFemenino;
use App\Domain\Entities\JugadorMasculino;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class TorneoController extends BaseController
{
    private SimuladorDeTorneo $simuladorDeTorneo;

    public function __construct(SimuladorDeTorneo $simuladorDeTorneo)
    {
        $this->simuladorDeTorneo = $simuladorDeTorneo;
    }

    /**
     * @OA\Post(
     *     path="/api/torneos/simular",
     *     summary="Simula un torneo de tenis",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tipo", "jugadores"},
     *             @OA\Property(property="tipo", type="string", enum={"masculino", "femenino"}),
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
             $ganador = $this->simuladorDeTorneo->simular($jugadores, $tipo);
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
