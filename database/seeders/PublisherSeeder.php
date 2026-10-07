<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Publisher::create([
            'publisher_name' => 'Rockstar Games',
            'website' => 'https://www.rockstargames.com',
            'country' => 'USA',
        ]);

        Publisher::create([
            'publisher_name' => 'CD Projekt',
            'website' => 'https://www.cdprojekt.com',
            'country' => 'Poland',
        ]);

        Publisher::create([
            'publisher_name' => 'Ubisoft',
            'website' => 'https://www.ubisoft.com',
            'country' => 'France',
        ]);
    }
}
