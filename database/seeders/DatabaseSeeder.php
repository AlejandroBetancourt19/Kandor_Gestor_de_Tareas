<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
     public function run(): void {
        $usuario = User::create([
            'name' => 'Usuario Demo',
            'email' => 'demo@kandor.test',
            'password' => 'secreto123',
        ]);

        $estudio = $usuario->categorias()->create(['nombre' => 'Estudio', 'color' => '#4f46e5']);
        $casa = $usuario->categorias()->create(['nombre' => 'Casa', 'color' => '#16a34a']);

        $usuario->tareas()->createMany([
            ['categoria_id' => $estudio->id, 'titulo' => 'Terminar el módulo de Laravel', 'estado'
            => 'en_proceso'],
            ['categoria_id' => $estudio->id, 'titulo' => 'Repasar migraciones', 'estado'
            => 'pendiente'],
            ['categoria_id' => $casa->id, 'titulo' => 'Pagar los servicios', 'estado'
            => 'completado', 'fecha_limite' => '2026-11-30'],
        ]);
    }
}
