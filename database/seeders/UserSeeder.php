<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Models\Business;
use App\Models\People;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $business = Business::where('ruc', '0993384053001')->first();
        $person = People::create([
            'name' => "Administrador PrymariSoft",
            'dni' => "0993384053001",
            'phone' => '099999999',
            'address' => '',
            'email' => '',
        ]);

        User::create([
            'name' => "Administrador PrymariSoft",
            'email' => "admin@primarys.soft",
            'password' => Hash::make('admin'),
            'business_id' => $business->id,
            'people_id' => $person->id
        ]);
    }
}
