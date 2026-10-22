<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Game::create([
            'publisher_id' => 1,
            'rawg_id' => null,
            'title' => 'Grand Theft Auto V',
            'description' => 'Open world action-adventure game.',
            'release_date' => '2013-09-17',
            'image_url' => null,
            'image_path' => null,
        ]);

        Game::create([
            'publisher_id' => 2,
            'rawg_id' => null,
            'title' => 'The Witcher 3: Wild Hunt',
            'description' => 'Open world role-playing game.',
            'release_date' => '2015-05-19',
            'image_url' => null,
            'image_path' => null,
        ]);

        Game::create([
            'publisher_id' => 2,
            'rawg_id' => null,
            'title' => 'Cyberpunk 2077',
            'description' => 'Open world action RPG set in Night City.',
            'release_date' => '2020-12-10',
            'image_url' => null,
            'image_path' => null,
        ]);
    }
}
