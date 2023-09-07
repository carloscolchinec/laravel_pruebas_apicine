<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PeliculaSalacineService;

/**
 * @OA\Tag(
 *     name="PeliculaSalacine",
 *     description="Operaciones relacionadas con PeliculaSalacine"
 * )
 */

class PeliculaSalacineController extends Controller
{
    protected $peliculaSalacineService;

    public function __construct(PeliculaSalacineService $peliculaSalacineService)
    {
        $this->peliculaSalacineService = $peliculaSalacineService;
    }

    /**
     * @OA\Get(
     *     path="/api/pelicula-salacine",
     *     operationId="getAllPeliculaSalacine",
     *     tags={"PeliculaSalacine"},
     *     summary="Obtener todas las películas en salas de cine",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de películas en salas de cine"
     *     )
     * )
     */

    public function index()
    {
        $peliculaSalacine = $this->peliculaSalacineService->getAllPeliculaSalacine();
        return response()->json($peliculaSalacine);
    }


    /**
     * @OA\Get(
     *     path="/api/pelicula-salacine/{id}",
     *     operationId="getPeliculaSalacineById",
     *     tags={"PeliculaSalacine"},
     *     summary="Obtener una película en sala de cine por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la película en sala de cine",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la película en sala de cine"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="PeliculaSalacine no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $peliculaSalacine = $this->peliculaSalacineService->getPeliculaSalacineById($id);
        if (!$peliculaSalacine) {
            return response()->json(['error' => 'PeliculaSalacine no encontrada'], 404);
        }
        return response()->json($peliculaSalacine);
    }

    /**
     * @OA\Post(
     *     path="/api/pelicula-salacine",
     *     operationId="createPeliculaSalacine",
     *     tags={"PeliculaSalacine"},
     *     summary="Crear una nueva película en sala de cine",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id_sala_cine", type="integer", example=1),
     *             @OA\Property(property="fecha_publicacion", type="string", format="date", example="2023-09-10"),
     *             @OA\Property(property="fecha_fin", type="string", format="date", example="2023-09-20"),
     *             @OA\Property(property="id_pelicula", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Película en sala de cine creada exitosamente"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $data = $request->only(['id_sala_cine', 'fecha_publicacion', 'fecha_fin', 'id_pelicula']);
        $peliculaSalacine = $this->peliculaSalacineService->createPeliculaSalacine($data);
        return response()->json($peliculaSalacine, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/pelicula-salacine/{id}",
     *     operationId="updatePeliculaSalacine",
     *     tags={"PeliculaSalacine"},
     *     summary="Actualizar una película en sala de cine existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la película en sala de cine",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id_sala_cine", type="integer", example=1),
     *             @OA\Property(property="fecha_publicacion", type="string", format="date", example="2023-09-10"),
     *             @OA\Property(property="fecha_fin", type="string", format="date", example="2023-09-20"),
     *             @OA\Property(property="id_pelicula", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Película en sala de cine actualizada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="PeliculaSalacine no encontrada"
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $data = $request->only(['id_sala_cine', 'fecha_publicacion', 'fecha_fin', 'id_pelicula']);
        $peliculaSalacine = $this->peliculaSalacineService->updatePeliculaSalacine($id, $data);
        if (!$peliculaSalacine) {
            return response()->json(['error' => 'PeliculaSalacine no encontrada'], 404);
        }
        return response()->json($peliculaSalacine);
    }


    /**
     * @OA\Delete(
     *     path="/api/pelicula-salacine/{id}",
     *     operationId="deletePeliculaSalacine",
     *     tags={"PeliculaSalacine"},
     *     summary="Eliminar una película en sala de cine",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la película en sala de cine",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pelicula en sala de cine eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="PeliculaSalacine no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $result = $this->peliculaSalacineService->deletePeliculaSalacine($id);
        if (!$result) {
            return response()->json(['error' => 'PeliculaSalacine no encontrada'], 404);
        }
        return response()->json(['message' => 'PeliculaSalacine eliminada']);
    }
}
