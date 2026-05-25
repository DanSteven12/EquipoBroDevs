<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AutenticacionController extends Controller
{
    /**
     * Registro de usuario simplificado.
     * Solo requiere: nombre, username, email y password.
     */
    public function registrarse(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuarios,username',
            'email' => 'required|string|email|max:255|unique:usuarios,email',
            'password' => 'required|string|min:6',
        ], [
            'username.unique' => 'El nombre de usuario ya está en uso.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'errores' => $validador->errors()
            ], 422);
        }

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Por defecto rol de estudiante/deportista
            'mfa_activo' => false,
            'email_verificado_at' => now(), // Activación inmediata
        ]);

        return response()->json([
            'mensaje' => 'Registro exitoso. Tu cuenta está activa y lista.',
            'usuario' => $usuario
        ], 201);
    }

    /**
     * Inicio de sesión simple.
     * Permite iniciar sesión con correo o nombre de usuario.
     */
    public function iniciarSesion(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'El campo de correo o usuario es requerido.',
            'password.required' => 'La contraseña es requerida.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'errores' => $validador->errors()
            ], 422);
        }

        $loginInput = $request->input('login');
        $password = $request->input('password');

        // Detecta si es un correo electrónico o un nombre de usuario
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credenciales = [
            $field => $loginInput,
            'password' => $password
        ];

        if (!$token = auth('api')->attempt($credenciales)) {
            return response()->json([
                'mensaje' => 'Credenciales inválidas. Verifica tu usuario/correo y contraseña.'
            ], 401);
        }

        return $this->responderConToken($token);
    }

    /**
     * Obtener el perfil del usuario autenticado.
     */
    public function obtenerPerfil(Request $request)
    {
        $usuario = auth('api')->user();
        if (!$usuario) {
            return response()->json(['mensaje' => 'No autorizado'], 401);
        }

        // Carga la relación con el rol
        $usuario->load('rol');

        return response()->json($usuario);
    }

    /**
     * Actualizar el perfil del usuario autenticado.
     */
    public function actualizarPerfil(Request $request)
    {
        $usuario = auth('api')->user();
        if (!$usuario) {
            return response()->json(['mensaje' => 'No autorizado'], 401);
        }

        $validador = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuarios,username,' . $usuario->id,
            'password' => 'nullable|string|min:6',
        ], [
            'username.unique' => 'El nombre de usuario ya está en uso.',
            'password.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'errores' => $validador->errors()
            ], 422);
        }

        $datos = [
            'nombre' => $request->nombre,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        $usuario->update($datos);

        return response()->json([
            'mensaje' => 'Perfil actualizado correctamente.',
            'usuario' => $usuario->load('rol')
        ]);
    }

    /**
     * Cerrar sesión.
     */
    public function cerrarSesion(Request $request)
    {
        auth('api')->logout();

        return response()->json([
            'mensaje' => 'Sesión cerrada exitosamente.'
        ])->withoutCookie('token');
    }

    /**
     * Refrescar token de sesión.
     */
    public function refrescarToken()
    {
        try {
            $newToken = auth('api')->refresh();
            return $this->responderConToken($newToken);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'No se pudo refrescar el token'], 401);
        }
    }

    /**
     * Responder estructurando el JWT token en cabecera y cookies.
     */
    protected function responderConToken($token)
    {
        $ttl = auth('api')->factory()->getTTL(); // Tiempo de vida del Token

        $usuario = auth('api')->user();
        $usuario->load('rol'); // Carga el rol del usuario

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl * 60,
            'user' => $usuario
        ])
        ->cookie('token', $token, $ttl, '/', null, false, true); // Guarda en cookie HttpOnly
    }
}
