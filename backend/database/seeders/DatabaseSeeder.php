<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $sqlFiles = [
            'flexhub_days.sql',
            'flexhub_cities.sql',
            'flexhub_musclegroups.sql',
            'flexhub_addresses.sql',
            'flexhub_gyms.sql',
            'flexhub_exercises.sql',
        ];

        foreach ($sqlFiles as $file) {
            $path = database_path('sql/' . $file);
            $sql = File::get($path);
            DB::unprepared($sql);
        }
    }
}
