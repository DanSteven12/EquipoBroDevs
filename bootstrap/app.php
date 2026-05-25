<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: [
            'token',
        ]);

        $middleware->alias([
            'jwt.verificar' => \App\Http\Middleware\VerificarTokenJWT::class,
            'rol.admin' => \App\Http\Middleware\VerificarRolAdmin::class,
            'rol.docente' => \App\Http\Middleware\VerificarRolDocente::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
