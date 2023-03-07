<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organization;
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
        $organization = Organization::first();

        $admin = User::create([
            'firstname'=>'Utilisateur',
            'lastname'=>'Admin',
            'email'=>'admin@dogger.com',
            'password'=>Hash::make('Pass1234'),
            'organization_id' => $organization->id
        ]);

        $user = User::create([
            'firstname'=>'Utilisateur',
            'lastname'=>'User',
            'email'=>'user@dogger.com',
            'password'=>Hash::make('Pass1234'),
            'organization_id' => $organization->id
        ]);

        $admin->assignRole('admin');
        $user->assignRole('user');

        $admin->save();
        $user->save();

        $organization->owner_id = $admin->id;
        $organization->save();
    }
}
