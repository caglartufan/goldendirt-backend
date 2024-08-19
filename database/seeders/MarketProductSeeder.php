<?php

namespace Database\Seeders;

use App\Models\MarketProduct;
use App\Models\Seed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = Seed::all();
        $seedPrices = [
            'Lettuce' => 5,
            'Carrot' => 15
        ];
        $products = $seeds->map(
            fn(Seed $seed) => ([
                'marketable_id' => $seed->id,
                'marketable_type' => Seed::class,
                'price' => $seedPrices[$seed->name]
            ])
        )->toArray();

        MarketProduct::insert($products);
    }
}
