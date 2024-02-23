<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create(
            [
                'name' => "Dashboard",
                'link' => "dashboard",
                'icon' => "stats-chart",
                'tab' => true,
                'selected' => true
            ],
        );

        Menu::create(
            [
                'name' => "Ventas",
                'link' => "venta",
                'icon' => "trending-up",
                'tab' => true,
                'selected' => false
            ]
        );

        Menu::create(
            [
                'name' => "Reporte V.",
                'link' => "reporte-ventas",
                'icon' => "clipboard",
                'tab' => true,
                'selected' => false
            ]           
        );

        Menu::create(
            [
                'name' => "Configuración",
                'link' => "configuracion",
                'icon' => "settings",
                'tab' => true,
                'selected' => false
            ]
        );

        Menu::create(
            [
                'name' => "Usuarios",
                'link' => "usuario",
                'icon' => "person",
                'tab' => false,
                'selected' => false
            ] 
        );

        Menu::create(
            [
                'name' => "Productos",
                'link' => "producto",
                'icon' => "pricetags",
                'tab' => false,
                'selected' => false
            ]           
        );

        Menu::create(
            [
                'name' => "Clientes",
                'link' => "cliente",
                'icon' => "people",
                'tab' => false,
                'selected' => false
            ]
        );
    }
}
