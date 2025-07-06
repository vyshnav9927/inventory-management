<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockMovement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();

        Warehouse::factory(10)->sequence(fn($sequence) => [
            'name' => 'warehouse_' . $sequence->index + 1
        ])->create();

        Product::factory(1000)->sequence(fn($sequence) => [
            'name' => 'product' . $sequence->index + 1
        ])->create();

        $warehouseIds = Warehouse::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        foreach ($productIds as $product) {
            $movements = [];
            $warehouseId = fake()->unique(true)->randomElement($warehouseIds);
            for ($i = 0; $i < 7; $i++) {
                $movements[] = [
                    'product_id' => $product,
                    'warehouse_id' => $warehouseId,
                    'quantity' =>  fake()->numberBetween(50, 100),
                    'type' => 1,
                    'movement_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            for ($j = 0; $j < 3; $j++) {
                $movements[] = [
                    'product_id' => $product,
                    'warehouse_id' => $warehouseId,
                    'quantity' =>  fake()->numberBetween(10, 30),
                    'type' => 0,
                    'movement_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            StockMovement::insert($movements);
        }
    }
}
