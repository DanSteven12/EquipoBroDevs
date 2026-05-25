<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Muestra la vista de gestión de usuarios con la lista de estudiantes.
     */
    public function usuarios(Request $request)
    {
        $busqueda = $request->input('search');
        $rol_id = $request->input('role', 2); // Por defecto Estudiante (2)

        $query = Usuario::where('role_id', $rol_id);

        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('email', 'like', "%{$busqueda}%");
            });
        }

        $usuarios = $query->orderBy('created_at', 'desc')->get();

        return view('administrador.usuarios', compact('usuarios', 'rol_id'));
    }

    /**
     * Registra un nuevo docente (rol_id 1).
     */
    public function registrarDocente(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validador->fails()) {
            if ($request->wantsJson()) {
                return response()->json($validador->errors(), 422);
            }
            return back()->withErrors($validador)->withInput();
        }

        $docente = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1, // Rol de Docente
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'mensaje' => 'Docente registrado exitosamente',
                'usuario' => $docente
            ], 201);
        }

        return back()->with('status', 'Docente registrado exitosamente.');
    }
}
