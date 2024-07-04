<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            StudentSeeder::class,
            PeriodSeeder::class,
            CategoriesWarehouseSeeder::class,
            WarehouseSeeder::class,
            ResponsibleSeeder::class,
            ModuleSeeder::class,
            CategoryItemSeeder::class,
            MeasurementUnitSeeder::class,
            OperationTypeSeeder::class,
            ProjectSeeder::class,
            ModStudSeeder::class,
        ]);
    }
}
