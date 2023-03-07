<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Error;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
        ]);

        if(config('app.env') === 'local') {
            $this->call([
                OrganizationSeeder::class,
                UserSeeder::class,
            ]);

            Project::factory()->count(13)->create();
            Error::factory()->count(56)->create();
        }
    }
}
