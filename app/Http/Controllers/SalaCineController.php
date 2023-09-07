<?php

namespace App\Http\Controllers;

use App\Models\SalaCine;
use Illuminate\Http\Request;
use App\Services\SalaCineService;


/**
 * @OA\Tag(
 *     name="SalaCine",
 *     description="Operaciones relacionadas con Salas de Cine"
 * )
 */

class SalaCineController extends Controller
{
    protected $salaCineService;

    public function __construct(SalaCineService $salaCineService)
    {
        $this->salaCineService = $salaCineService;
    }

        /**
     * @OA\Get(
     *     path="/api/salas-cine",
     *     operationId="getAllSalasCine",
     *     tags={"SalaCine"},
     *     summary="Obtener todas las salas de cine",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de salas de cine"
     *     )
     * )
     */

    public function index()
    {
        $salasCine = $this->salaCineService->getAllSalasCine();
        return response()->json($salasCine);
    }


    /**
     * @OA\Get(
     *     path="/api/salas-cine/{id}",
     *     operationId="getSalaCineById",
     *     tags={"SalaCine"},
     *     summary="Obtener una sala de cine por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la sala de cine",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la sala de cine"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sala de Cine no encontrada"
     *     )
     * )
     */

    public function show($id)
    {
        $salaCine = $this->salaCineService->getSalaCineById($id);
        if (!$salaCine) {
            return response()->json(['error' => 'Sala de Cine no encontrada'], 404);
        }
        return response()->json($salaCine);
    }

    /**
     * @OA\Post(
     *     path="/api/salas-cine",
     *     operationId="createSalaCine",
     *     tags={"SalaCine"},
     *     summary="Crear una nueva sala de cine",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Nombre de la sala de cine"),
     *             @OA\Property(property="estado", type="string", example="Abierta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sala de Cine creada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ya existe una sala de cine con este nombre"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $data = $request->only(['nombre', 'estado']);
    
        // Verificar si ya existe una sala de cine con el mismo nombre
        $existingSalaCine = SalaCine::where('nombre', $data['nombre'])->first();
        
        if ($existingSalaCine) {
            return response()->json(['error' => 'Ya existe una sala de cine con este nombre'], 422);
        }
    
        $salaCine = $this->salaCineService->createSalaCine($data);
        return response()->json($salaCine, 201);
    }
    

    /**
     * @OA\Put(
     *     path="/api/salas-cine/{id}",
     *     operationId="updateSalaCine",
     *     tags={"SalaCine"},
     *     summary="Actualizar una sala de cine existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la sala de cine",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Nuevo nombre de la sala de cine"),
     *             @OA\Property(property="estado", type="string", example="Cerrada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sala de Cine actualizada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sala de Cine no encontrada"
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $data = $request->only(['nombre', 'estado']);
        $salaCine = $this->salaCineService->updateSalaCine($id, $data);
        if (!$salaCine) {
            return response()->json(['error' => 'Sala de Cine no encontrada'], 404);
        }
        return response()->json($salaCine);
    }

    /**
     * @OA\Delete(
     *     path="/api/salas-cine/{id}",
     *     operationId="deleteSalaCine",
     *     tags={"SalaCine"},
     *     summary="Eliminar una sala de cine",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la sala de cine",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sala de Cine eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sala de Cine no encontrada"
     *     )
     * )
     */

    public function destroy($id)
    {
        $result = $this->salaCineService->deleteSalaCine($id);
        if (!$result) {
            return response()->json(['error' => 'Sala de Cine no encontrada'], 404);
        }
        return response()->json(['message' => 'Sala de Cine eliminada']);
    }
}
