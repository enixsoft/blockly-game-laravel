<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "admin",
            'email' => "admin@blocklyhra.sk",
            'role' => "admin",
            'password' => Hash::make(config('app.admin_password', 'admin123')),
        ]);
    }
}
