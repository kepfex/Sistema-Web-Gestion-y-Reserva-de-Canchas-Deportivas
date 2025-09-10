<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea un usuario de administrador y un perfil asociado.
        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@ejemplo.com',
        // ])->profile()->save(Profile::factory()->make());

        // Crea 10 usuarios y perfiles de prueba.
        User::factory(10)->create()->each(function ($user) {
            $user->profile()->save(Profile::factory()->make());
        });
    }
}
