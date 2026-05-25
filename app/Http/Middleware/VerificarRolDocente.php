<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRolDocente
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = auth('api')->user();

        if (!$usuario || !in_array($usuario->role_id, [0, 1])) {
            return response()->json(['mensaje' => 'Acceso denegado. Se requiere rol de Docente o Administrador.'], 403);
        }

        return $next($request);
    }
}
