<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@martmandu.com.np',
        ]);

        // Brands
        $brands = Brand::factory()->count(4)->create();

        // Categories
        $categories = Category::factory()->count(4)->create();

        // Users
        $users = User::factory()->count(3)->create();

        // Addresses for each user
        $users->each(function ($user) {
            // for single address creation
            // $user->addresses()->save(Address::factory()->make());

            // for multiple address creation using for
            Address::factory()->count(rand(1, 10))->for($user)->create();

            // for multiple address creation using user_id
            // Address::factory()->count(rand(1,10))->create(['user_id' => $user->id]);
        });

        // Products
        $products = Product::factory()
            ->count(10)
            ->state(fn() => [
                'brand_id' => $brands->random()->id,
                'category_id' => $categories->random()->id,
            ])
            ->create();

        // Orders
        foreach (range(1, rand(1, 10)) as $i) {
            $user = $users->random();
            $address = $user->addresses()->inRandomOrder()->first();

            $order = Order::factory()->for($user)->for($address)->create();

            // Add random items to the order
            $itemsCount = rand(1, 3);
            $total = 0;

            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                $unitPrice = $product->price;
                $itemTotal = $unitPrice * $quantity;

                OrderItem::factory()
                    ->for($product)
                    ->for($order)
                    ->create([
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $itemTotal,
                ]);

                $total += $itemTotal;
            }

            $order->update(['grand_total' => $total]);
        }
    }
}
