<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use App\Services\PeliculaService;

/**
 * @OA\Info(
 *     title="API de Películas",
 *     version="1.0",
 *     description="API para gestionar películas"
 * )
 */


class PeliculaController extends Controller
{
    protected $peliculaService;

    public function __construct(PeliculaService $peliculaService)
    {
        $this->peliculaService = $peliculaService;
    }

    /**
     * @OA\Get(
     *     path="/api/peliculas",
     *     operationId="getAllPeliculas",
     *     tags={"Peliculas"},
     *     summary="Obtener todas las películas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de películas"
     *     )
     * )
     */

    public function index()
    {
        $peliculas = $this->peliculaService->getAllPeliculas();
        return response()->json($peliculas);
    }


    /**
     * @OA\Get(
     *     path="/api/peliculas/{id}",
     *     operationId="getPeliculaById",
     *     tags={"Peliculas"},
     *     summary="Obtener una película por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la película",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la película"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pelicula no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        // Validar que el ID sea un número entero positivo
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'El ID de la película debe ser un número entero positivo'], 422);
        }

        $pelicula = $this->peliculaService->getPeliculaById($id);

        if (!$pelicula) {
            return response()->json(['error' => 'Pelicula no encontrada'], 404);
        }

        return response()->json($pelicula);
    }





    /**
     * @OA\Post(
     *     path="/api/peliculas",
     *     operationId="createPelicula",
     *     tags={"Peliculas"},
     *     summary="Crear una nueva película",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Nombre de la película"),
     *             @OA\Property(property="duracion", type="integer", example=120)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Película creada exitosamente",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Los datos proporcionados son inválidos.")
     *         )
     *     )
     * )
     */

    public function store(Request $request)
    {
        // Validar que se proporcionen los campos 'nombre' y 'duracion' en el cuerpo de la solicitud
        if (!$request->has('nombre') || !$request->has('duracion')) {
            return response()->json(['error' => 'Los campos "nombre" y "duracion" son requeridos'], 422);
        }

        $data = $request->only(['nombre', 'duracion']);

        // Validar que la duración sea un número entero positivo
        if (!is_numeric($data['duracion']) || $data['duracion'] <= 0) {
            return response()->json(['error' => 'La duración debe ser un número entero positivo'], 422);
        }

        $existingPelicula = Pelicula::where('nombre', $data['nombre'])->first();

        if ($existingPelicula) {
            return response()->json(['error' => 'El nombre de la película ya existe'], 422);
        }

        $pelicula = $this->peliculaService->createPelicula($data);

        return response()->json($pelicula, 201);
    }


    /**
     * @OA\Put(
     *     path="/api/peliculas/{id}",
     *     operationId="updatePelicula",
     *     tags={"Peliculas"},
     *     summary="Actualizar una película existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la película",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Nuevo nombre de la película"),
     *             @OA\Property(property="duracion", type="integer", example=150)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Película actualizada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos de solicitud inválidos"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pelicula no encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Validar si se proporcionan los campos 'nombre' y 'duracion' en la solicitud JSON
        if (!$request->has('nombre') || !$request->has('duracion')) {
            return response()->json(['error' => 'Los campos "nombre" y "duracion" son requeridos'], 400);
        }

        $data = $request->only(['nombre', 'duracion']);
        $pelicula = $this->peliculaService->updatePelicula($id, $data);

        if (!$pelicula) {
            return response()->json(['error' => 'Pelicula no encontrada'], 404);
        }

        return response()->json($pelicula);
    }


    /**
     * @OA\Delete(
     *     path="/api/peliculas/{id}",
     *     operationId="deletePelicula",
     *     tags={"Peliculas"},
     *     summary="Eliminar una película",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la película",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pelicula eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pelicula no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Validar que el ID sea un número entero positivo
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'El ID de la película debe ser un número entero positivo'], 400);
        }

        $result = $this->peliculaService->deletePelicula($id);
        if (!$result) {
            return response()->json(['error' => 'Pelicula no encontrada'], 404);
        }
        return response()->json(['message' => 'Pelicula eliminada']);
    }
}
