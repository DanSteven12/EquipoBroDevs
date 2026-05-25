<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarTokenJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            \Log::info("JWT Middleware: Checking request for " . $request->path());
            $token = $request->header('Authorization')
                ?? $request->cookie('token')
                ?? $request->bearerToken();

            if ($token) {
                \Log::info("JWT Middleware: Token found.");
                if (!$request->header('Authorization')) {
                    \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::setToken($token);
                }
                $user = \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::authenticate();
                \Log::info("JWT Middleware: User authenticated: " . ($user ? $user->email : 'FAILED'));
            } else {
                \Log::warning("JWT Middleware: No token provided for " . $request->path());
                if (!$request->wantsJson() && !$request->ajax()) {
                    return redirect()->route('login');
                }
                return response()->json(['mensaje' => 'Token no proporcionado'], 401);
            }

            if (!$user) {
                if (!$request->wantsJson() && !$request->ajax()) {
                    return redirect()->route('login');
                }
                return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
            }
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException $e) {
            \Log::error("JWT Middleware: Token Expired: " . $e->getMessage());
            if (!$request->wantsJson()) {
                return redirect()->route('login')->with('error', 'Tu sesión ha expirado.');
            }
            return response()->json(['mensaje' => 'Token expirado'], 401);
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException $e) {
            \Log::error("JWT Middleware: Token Invalid: " . $e->getMessage());
            if (!$request->wantsJson()) {
                return redirect()->route('login');
            }
            return response()->json(['mensaje' => 'Token inválido'], 401);
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
            \Log::error("JWT Middleware: JWT Error: " . $e->getMessage());
            if (!$request->wantsJson()) {
                return redirect()->route('login');
            }
            return response()->json(['mensaje' => 'Token no proporcionado'], 401);
        }

        return $next($request);
    }
}
