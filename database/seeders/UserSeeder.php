<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'firstname'=>'Utilisateur',
            'lastname'=>'Admin',
            'email'=>'admin@dogger.com',
            'password'=>Hash::make('Pass1234'),
        ]);

        $user = User::create([
            'firstname'=>'Utilisateur',
            'lastname'=>'User',
            'email'=>'user@dogger.com',
            'password'=>Hash::make('Pass1234'),
        ]);

        $admin->assignRole('admin');
        $user->assignRole('user');

        $admin->save();
        $user->save();
    }
}
