<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'WELCOME10',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(3),
            'usage_limit' => 100,
            'active' => true,
        ]);

        Coupon::create([
            'code' => 'SAVE5',
            'discount_type' => 'fixed',
            'discount_value' => 5,
            'starts_at' => now(),
            'expires_at' => now()->addMonth(),
            'usage_limit' => 50,
            'active' => true,
        ]);
    }
}
