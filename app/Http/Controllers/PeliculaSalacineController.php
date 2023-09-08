<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PeliculaSalacineService;
use Carbon\Carbon;

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
     * @OA\Get(
     *     path="/api/peliculas/cantidad-publicadas",
     *     operationId="getQuantityMoviesPublishedBeforeDate",
     *     tags={"Peliculas"},
     *     summary="Obtener la cantidad de películas publicadas antes de una fecha",
     *     @OA\Parameter(
     *         name="fecha",
     *         in="query",
     *         description="Fecha a partir de la cual se contarán las películas publicadas",
     *         required=true,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cantidad de películas publicadas y lista de películas",
     *         @OA\JsonContent(
     *             @OA\Property(property="cantidad", type="integer", example=5),
     *         )
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
    public function getQuantityMoviesPublishedBeforeDate(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date', // Asegura que 'fecha' esté presente y sea una fecha válida
        ]);

        $fecha = Carbon::parse($request->input('fecha')); // Parsea la fecha a objeto Carbon
        $peliculas = $this->peliculaSalacineService->getQuantityMoviesPublishedBeforeDate($fecha);
        $cantidadPeliculas = $peliculas->count();

        return response()->json([
            'cantidad' => $cantidadPeliculas,
            'peliculas' => $peliculas,
        ]);
    }



    /**
     * @OA\Get(
     *     path="/api/pelicula-salacine/buscar",
     *     operationId="buscarPeliculaPorNombreYSala",
     *     tags={"PeliculaSalacine"},
     *     summary="Buscar una película por nombre de película e identificador de sala",
     *     @OA\Parameter(
     *         name="nombre",
     *         in="query",
     *         description="Nombre de la película",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id_sala",
     *         in="query",
     *         description="ID de la sala de cine",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la película encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Nombre de la película"),
     *                 @OA\Property(property="duracion", type="integer", example=120),
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pelicula no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="error", type="string", example="PeliculaSalacine no encontrada"),
     *             }
     *         )
     *     )
     * )
     */
    public function searchMovieByNameAndRoom(Request $request)
    {

        if (!$request->has('nombre')) {
            return response()->json(['error' => 'El campo "nombre" es requerido'], 400);
        }

        if (!$request->has('id_sala')) {
            return response()->json(['error' => 'El campo "id_sala" es requerido'], 400);
        }

        $nombre = $request->input('nombre');
        $idSala = $request->input('id_sala');


        $pelicula = $this->peliculaSalacineService->searchMovieByNameAndRoom($nombre, $idSala);

        if (!$pelicula) {
            return response()->json(['error' => 'PeliculaSalacine no encontrada'], 404);
        }

        return response()->json($pelicula);
    }

    public function getQuantityPublishedMovies(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date', // Asegura que 'fecha' esté presente y sea una fecha válida
        ]);

        $fecha = $request->input('fecha');
        $cantidadPeliculas = $this->peliculaSalacineService->getQuantityMoviesPublishedBeforeDate($fecha);

        return response()->json(['cantidad' => $cantidadPeliculas]);
    }



    public function searchMoviesByCinemaName(Request $request)
    {
        $request->validate([
            'nombre_sala' => 'required|string',
        ]);

        $nombreSala = $request->input('nombre_sala');
        $cantidadPeliculas = $this->peliculaSalacineService->getMovieCountByCinemaName($nombreSala);
        $mensaje = $this->getMessageForMovieCount($cantidadPeliculas);

        return response()->json(['mensaje' => $mensaje]);
    }

    private function getMessageForMovieCount($cantidadPeliculas)
    {
        if ($cantidadPeliculas < 3) {
            return 'Sala casi Vacía';
        } elseif ($cantidadPeliculas >= 3 && $cantidadPeliculas <= 5) {
            return 'Sala casi Llena';
        } else {
            return 'Sala Llena';
        }
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
