<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definimos los registros que se insertarán en la tabla "menu".
        $menus = [
            [
                'nombre' => 'Modulo Compra',
                'icono' => 'fas fa-shopping-cart',
            ],
            [
                'nombre' => 'Modulo Venta',
                'icono' => 'fas fa-cash-register',
            ],
            [
                'nombre' => 'Modulo Membresía',
                'icono' => 'fas fa-id-card',
            ],
            [
                'nombre' => 'Modulo Admin',
                'icono' => 'fas fa-user-cog',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu); 
        }
    }
}
