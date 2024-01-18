<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Business;
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
        User::create([
            'name' => "admin",
            'email' => "admin@primarys.soft",
            'password' => Hash::make('admin'),
            'business_id' => $business->id
        ]);
    }
}
