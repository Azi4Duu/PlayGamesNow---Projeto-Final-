<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GamePlatform;
use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamePlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gta = Game::where('title', 'Grand Theft Auto V')->first();
        $witcher = Game::where('title', 'The Witcher 3: Wild Hunt')->first();
        $cyberpunk = Game::where('title', 'Cyberpunk 2077')->first();

        $steam = Platform::where('platform_name', 'Steam')->first();
        $playstation = Platform::where('platform_name', 'PlayStation')->first();
        $xbox = Platform::where('platform_name', 'Xbox')->first();
        $gog = Platform::where('platform_name', 'GOG')->first();

        GamePlatform::create([
            'game_id' => $gta->id,
            'platform_id' => $steam->id,
            'price' => 19.99,
            'old_price' => 29.99,
            'active' => true,
        ]);

        GamePlatform::create([
            'game_id' => $gta->id,
            'platform_id' => $playstation->id,
            'price' => 24.99,
            'old_price' => 34.99,
            'active' => true,
        ]);

        GamePlatform::create([
            'game_id' => $witcher->id,
            'platform_id' => $steam->id,
            'price' => 14.99,
            'old_price' => 29.99,
            'active' => true,
        ]);

        GamePlatform::create([
            'game_id' => $witcher->id,
            'platform_id' => $gog->id,
            'price' => 16.99,
            'old_price' => null,
            'active' => true,
        ]);

        GamePlatform::create([
            'game_id' => $cyberpunk->id,
            'platform_id' => $steam->id,
            'price' => 29.99,
            'old_price' => 49.99,
            'active' => true,
        ]);

        GamePlatform::create([
            'game_id' => $cyberpunk->id,
            'platform_id' => $xbox->id,
            'price' => 34.99,
            'old_price' => 49.99,
            'active' => true,
        ]);
    }
}
