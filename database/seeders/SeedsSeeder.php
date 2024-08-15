<?php

namespace Database\Seeders;

use App\Models\Seed;
use Illuminate\Database\Seeder;

class SeedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'name' => 'Lettuce',
                'image' => env('APP_URL') . '/images/crops/lettuce.png',
                'seconds_to_grow_up' => 30,
                'seed_cost_at_market' => 5,
                'xp_reward' => 10,
                'level_required_to_plant' => 1
            ], [
                'name' => 'Carrot',
                'image' => env('APP_URL') . '/images/crops/carrot.png',
                'seconds_to_grow_up' => 60,
                'seed_cost_at_market' => 15,
                'xp_reward' => 20,
                'level_required_to_plant' => 2
            ]
        ];

        Seed::insert($seeds);
    }
}
