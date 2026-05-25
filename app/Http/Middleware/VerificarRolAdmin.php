<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRolAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = auth('api')->user();

        if (!$usuario || $usuario->role_id !== 0) {
            if (!$request->wantsJson() && !$request->ajax()) {
                return redirect()->route('login')->with('error', 'Acceso denegado. Se requiere rol de Administrador.');
            }
            return response()->json(['mensaje' => 'Acceso denegado. Se requiere rol de Administrador.'], 403);
        }

        return $next($request);
    }
}
