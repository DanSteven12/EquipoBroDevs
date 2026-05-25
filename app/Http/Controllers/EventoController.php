<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    /**
     * Listar todos los eventos con búsqueda y filtros por categoría.
     */
    public function index(Request $request)
    {
        $query = Evento::with('usuario');

        // Búsqueda por título o descripción
        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        // Filtrado por categoría deportiva
        if ($request->filled('categoria')) {
            $categoria = $request->input('categoria');
            $query->where('categoria', $categoria);
        }

        // Ordenar por fecha cronológica (próximos eventos primero)
        $eventos = $query->orderBy('fecha', 'asc')->get();

        return response()->json($eventos);
    }

    /**
     * Crear un nuevo evento.
     */
    public function store(Request $request)
    {
        $usuario = auth('api')->user();
        if (!$usuario) {
            return response()->json(['mensaje' => 'No autorizado'], 401);
        }

        $validador = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'lugar' => 'required|string|max:255',
            'categoria' => 'required|string|max:100',
            'imagen' => 'nullable|string',
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'fecha.required' => 'La fecha y hora son obligatorias.',
            'lugar.required' => 'El lugar es obligatorio.',
            'categoria.required' => 'La categoría es obligatoria.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'errores' => $validador->errors()
            ], 422);
        }

        // Mapeo básico de imágenes por defecto según la categoría si no se proporciona una
        $imagen = $request->input('imagen');
        if (empty($imagen)) {
            $categoriaLower = mb_strtolower($request->categoria);
            if (str_contains($categoriaLower, 'fútbol') || str_contains($categoriaLower, 'futbol')) {
                $imagen = '/img/futbol.jpg';
            } elseif (str_contains($categoriaLower, 'baloncesto') || str_contains($categoriaLower, 'basquet')) {
                $imagen = '/img/baloncesto.jpg';
            } elseif (str_contains($categoriaLower, 'ciclismo') || str_contains($categoriaLower, 'bici')) {
                $imagen = '/img/ciclismo.jpg';
            } elseif (str_contains($categoriaLower, 'senderismo') || str_contains($categoriaLower, 'trekking') || str_contains($categoriaLower, 'montaña')) {
                $imagen = '/img/senderismo.jpg';
            } elseif (str_contains($categoriaLower, 'atletismo') || str_contains($categoriaLower, 'correr') || str_contains($categoriaLower, 'running')) {
                $imagen = '/img/atletismo.jpg';
            } else {
                $imagen = '/img/recreativo.jpg'; // Imagen genérica
            }
        }

        $evento = Evento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'lugar' => $request->lugar,
            'categoria' => $request->categoria,
            'imagen' => $imagen,
            'usuario_id' => $usuario->id,
        ]);

        return response()->json([
            'mensaje' => 'Evento deportivo creado con éxito.',
            'evento' => $evento->load('usuario')
        ], 201);
    }

    /**
     * Mostrar los detalles de un evento específico.
     */
    public function show($id)
    {
        $evento = Evento::with('usuario')->find($id);

        if (!$evento) {
            return response()->json(['mensaje' => 'Evento no encontrado.'], 404);
        }

        return response()->json($evento);
    }

    /**
     * Actualizar un evento existente.
     */
    public function update(Request $request, $id)
    {
        $usuario = auth('api')->user();
        if (!$usuario) {
            return response()->json(['mensaje' => 'No autorizado'], 401);
        }

        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json(['mensaje' => 'Evento no encontrado.'], 404);
        }

        // Validar que el usuario sea el creador o un administrador (rol_id = 0)
        if ($evento->usuario_id !== $usuario->id && $usuario->role_id !== 0) {
            return response()->json(['mensaje' => 'No tienes permisos para editar este evento.'], 403);
        }

        $validador = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'lugar' => 'required|string|max:255',
            'categoria' => 'required|string|max:100',
            'imagen' => 'nullable|string',
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'fecha.required' => 'La fecha y hora son obligatorias.',
            'lugar.required' => 'El lugar es obligatorio.',
            'categoria.required' => 'La categoría es obligatoria.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'errores' => $validador->errors()
            ], 422);
        }

        $datos = $request->only(['titulo', 'descripcion', 'fecha', 'lugar', 'categoria']);
        if ($request->filled('imagen')) {
            $datos['imagen'] = $request->imagen;
        }

        $evento->update($datos);

        return response()->json([
            'mensaje' => 'Evento actualizado correctamente.',
            'evento' => $evento->load('usuario')
        ]);
    }

    /**
     * Eliminar un evento.
     */
    public function destroy($id)
    {
        $usuario = auth('api')->user();
        if (!$usuario) {
            return response()->json(['mensaje' => 'No autorizado'], 401);
        }

        $evento = Evento::find($id);
        if (!$evento) {
            return response()->json(['mensaje' => 'Evento no encontrado.'], 404);
        }

        // Validar que el usuario sea el creador o un administrador (rol_id = 0)
        if ($evento->usuario_id !== $usuario->id && $usuario->role_id !== 0) {
            return response()->json(['mensaje' => 'No tienes permisos para eliminar este evento.'], 403);
        }

        $evento->delete();

        return response()->json([
            'mensaje' => 'Evento eliminado exitosamente.'
        ]);
    }
}
