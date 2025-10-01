<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Jefe de Recintos
        User::create([
            'name' => 'Jefe de Recintos',
            'email' => 'jefe.recintos@municipalidadarica.cl',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Cambiar en producción
            'role' => 'jefe_recintos',
            'recinto_asignado_id' => null,
            'activo' => true
        ]);

        // Usuario Admin del Sistema
        User::create([
            'name' => 'Administrador Sistema',
            'email' => 'admin@municipalidadarica.cl',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // Cambiar en producción
            'role' => 'admin',
            'recinto_asignado_id' => null,
            'activo' => true
        ]);

        $this->command->info('Usuarios administrativos creados exitosamente');
    }
}