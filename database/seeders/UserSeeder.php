<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@udone.edu.ve',
            'password' => Hash::make('password'),
            'student_id' => 'ADM-001',
            'career' => 'Administración del Sistema',
            'is_admin' => true,
            'is_moderator' => true,
            'email_verified_at' => now(),
        ]);

        // Create moderator user
        User::create([
            'name' => 'Moderador',
            'email' => 'moderador@udone.edu.ve',
            'password' => Hash::make('password'),
            'student_id' => 'MOD-001',
            'career' => 'Informática',
            'is_admin' => false,
            'is_moderator' => true,
            'email_verified_at' => now(),
        ]);

        // Create regular users
        User::create([
            'name' => 'María García',
            'email' => 'maria@udone.edu.ve',
            'password' => Hash::make('password'),
            'student_id' => '2021-0001',
            'career' => 'Ingeniería de Sistemas',
            'bio' => 'Estudiante de Ingeniería de Sistemas, 5to semestre.',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Carlos Rodríguez',
            'email' => 'carlos@udone.edu.ve',
            'password' => Hash::make('password'),
            'student_id' => '2020-0015',
            'career' => 'Contaduría Pública',
            'bio' => 'Apasionado por las finanzas y la contabilidad.',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ana Martínez',
            'email' => 'ana@udone.edu.ve',
            'password' => Hash::make('password'),
            'student_id' => '2022-0032',
            'career' => 'Administración',
            'bio' => 'Estudiante de Administración de Empresas.',
            'email_verified_at' => now(),
        ]);
    }
}
