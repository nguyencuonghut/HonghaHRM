<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentsTableSeeder::class,
            DivisionsTableSeeder::class,
            AdminsTableSeeder::class,
            UsersTableSeeder::class,
            UserDepartmentTableSeeder::class,
            UserDivisionTableSeeder::class,
            PositionsTableSeeder::class,
            UserPositionTableSeeder::class,
            ProvincesTableSeeder::class,
            DistrictsTableSeeder::class,
            CommunesTableSeeder::class,
        ]);
    }
}
