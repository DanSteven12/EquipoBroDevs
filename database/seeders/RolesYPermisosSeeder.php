<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesYPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            'acceder_dashboard' => 'Acceso al panel principal',
            'gestionar_usuarios' => 'Crear, editar y eliminar usuarios',
            'ver_reportes' => 'Ver reportes académicos',
            'gestionar_contenidos' => 'Subir y editar contenidos',
        ];

        foreach ($permisos as $nombre => $descripcion) {
            \App\Models\Permiso::firstOrCreate(['nombre' => $nombre], ['descripcion' => $descripcion]);
        }

        // Forzar la creación del Administrador con ID 0
        \Illuminate\Support\Facades\DB::statement("SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO'");

        $roles = [
            ['id' => 0, 'nombre' => 'administrador', 'descripcion' => 'Acceso total al sistema'],
            ['id' => 1, 'nombre' => 'docente', 'descripcion' => 'Gestión de contenidos y evaluaciones'],
            ['id' => 2, 'nombre' => 'estudiante', 'descripcion' => 'Acceso a contenidos y reportes propios'],
        ];

        foreach ($roles as $r) {
            \Illuminate\Support\Facades\DB::table('roles')->updateOrInsert(
                ['id' => $r['id']],
                [
                    'nombre' => $r['nombre'],
                    'descripcion' => $r['descripcion'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            $rol = \App\Models\Rol::find($r['id']);
            if ($r['nombre'] === 'administrador') {
                $rol->permisos()->sync(\App\Models\Permiso::all());
            } elseif ($r['nombre'] === 'docente') {
                $rol->permisos()->sync(\App\Models\Permiso::whereIn('nombre', ['acceder_dashboard', 'ver_reportes', 'gestionar_contenidos'])->get());
            } else {
                $rol->permisos()->sync(\App\Models\Permiso::whereIn('nombre', ['acceder_dashboard'])->get());
            }
        }
    }
}
