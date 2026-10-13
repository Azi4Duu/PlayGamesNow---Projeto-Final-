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
            'icon_path' => 'assets/images/platforms/steam.png',
        ]);

        Platform::create([
            'platform_name' => 'Epic Games',
            'icon_path' => 'assets/images/platforms/epic-games.png',
        ]);

        Platform::create([
            'platform_name' => 'Xbox',
            'icon_path' => 'assets/images/platforms/xbox.png',
        ]);

        Platform::create([
            'platform_name' => 'PlayStation',
            'icon_path' => 'assets/images/platforms/playstation.png',
        ]);

        Platform::create([
            'platform_name' => 'GOG',
            'icon_path' => 'assets/images/platforms/gog.png',
        ]);
    }
}
