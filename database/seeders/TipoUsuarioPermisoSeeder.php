<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoUsuario;
use App\Models\Permiso;
use App\Models\TipoUsuarioPermiso;

class TipoUsuarioPermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el TipoUsuario con codTipoUsuario = 3
        $tipoUsuario = TipoUsuario::find(3);

        if ($tipoUsuario) {
            // Obtener todos los permisos con la acción 'ver'
            $permisosVer = Permiso::where('accion', 'ver')->get();

            // Asignar los permisos 'ver' al TipoUsuario con codTipoUsuarioF = 3
            foreach ($permisosVer as $permiso) {
                TipoUsuarioPermiso::create([
                    'codTipoUsuarioF' => $tipoUsuario->codTipoUsuario,  // Relacionar con el TipoUsuario 3
                    'codPermisoF' => $permiso->codPermiso,  // Relacionar con el permiso 'ver'
                ]);
            }
        }
    }
}
