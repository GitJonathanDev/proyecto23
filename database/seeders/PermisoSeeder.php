<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permiso;
use App\Models\Opcion;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las opciones
        $opciones = Opcion::all();

        // Definir las acciones que se asignarán a cada opción
        $acciones = ['ver', 'editar', 'eliminar', 'registrar'];

        // Asignar permisos a cada opción
        foreach ($opciones as $opcion) {
            foreach ($acciones as $accion) {
                Permiso::create([
                    'codOpcionF' => $opcion->codOpcion, // Relacionar con la opción
                    'accion' => $accion,
                ]);
            }
        }
    }
}
