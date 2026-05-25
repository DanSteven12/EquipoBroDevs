<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::updateOrInsert(
            ['email' => 'admin@universidad.edu'],
            [
                'nombre' => 'Administrador Sistema',
                'password' => Hash::make('Admin12345678'),
                'role_id' => 0,
                'mfa_activo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
