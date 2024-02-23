<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\RoleHasMenu;
use Spatie\Permission\Models\Role;

class RolesMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::where('name', 'admin')->first();
        $menu = Menu::all();

        foreach ($menu as $key => $value) {
            RoleHasMenu::create(
                [
                    'role_id' => $role->id,
                    'menu_id' => $value->id
                ],
            );            
        }

    }
}
