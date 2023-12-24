<?php

namespace Database\Seeders;

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
        $user = User::updateOrCreate([
            'npk' => 'superadmin'
        ],[
            'name' => 'Superadmin',
            'email' => 'superadmin@app.com',
            'password' => 'admin',
        ]);
        $user->assignRole('Superadmin');
    }
}