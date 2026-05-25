<?php

use Illuminate\Support\Facades\Route;

// Redireccionar la raíz a index.html
Route::get('/', function () {
    $path = base_path('index.html');
    if (file_exists($path)) {
        return file_get_contents($path);
    }
    return response('Por favor, crea index.html en la raíz del proyecto.', 200)
        ->header('Content-Type', 'text/html');
});

// Servir páginas HTML desde la raíz
$htmlFiles = ['index', 'eventos', 'contacto', 'login', 'registro', 'perfil'];
foreach ($htmlFiles as $file) {
    Route::get("/{$file}.html", function () use ($file) {
        $path = base_path("{$file}.html");
        if (file_exists($path)) {
            return response(file_get_contents($path), 200)
                ->header('Content-Type', 'text/html');
        }
        abort(404, "Página {$file}.html no encontrada en la raíz.");
    });
    
    // También permitir cargarlas sin el .html para flexibilidad en navegación
    Route::get("/{$file}", function () use ($file) {
        $path = base_path("{$file}.html");
        if (file_exists($path)) {
            return response(file_get_contents($path), 200)
                ->header('Content-Type', 'text/html');
        }
        abort(404, "Página {$file}.html no encontrada en la raíz.");
    });
}

// Servir la hoja de estilo CSS desde /css/style.css
Route::get('/css/style.css', function () {
    $path = base_path('css/style.css');
    if (file_exists($path)) {
        return response(file_get_contents($path))->header('Content-Type', 'text/css');
    }
    abort(404, 'Archivo css/style.css no encontrado.');
});

// Servir el script JS desde /js/script.js
Route::get('/js/script.js', function () {
    $path = base_path('js/script.js');
    if (file_exists($path)) {
        return response(file_get_contents($path))->header('Content-Type', 'application/javascript');
    }
    abort(404, 'Archivo js/script.js no encontrado.');
});

// Servir imágenes desde /img/
Route::get('/img/{filename}', function ($filename) {
    $path = base_path('img/' . $filename);
    if (file_exists($path)) {
        $file = file_get_contents($path);
        $type = mime_content_type($path);
        return response($file)->header('Content-Type', $type);
    }
    
    // Retornar un error 404 para imágenes faltantes
    abort(404, 'Imagen no encontrada.');
});
