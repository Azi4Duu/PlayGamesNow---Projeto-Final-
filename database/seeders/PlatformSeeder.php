<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Platform::create([
            'platform_name' => 'Steam',
        ]);

        Platform::create([
            'platform_name' => 'Epic Games',
        ]);

        Platform::create([
            'platform_name' => 'Xbox',
        ]);

        Platform::create([
            'platform_name' => 'PlayStation',
        ]);

        Platform::create([
            'platform_name' => 'GOG',
        ]);
    }
}
