<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'address_id' => Address::factory(),
            'grand_total' => $this->faker->randomFloat(2, 100, 2000),
            'payment_method' => $this->faker->randomElement(['cod', 'card', 'wallet']),
            'payment_status' => $this->faker->randomElement(['paid', 'pending', 'failed']),
            'status' => $this->faker->randomElement(['new', 'pending', 'processing', 'shipped' , 'completed' , 'cancelled' ]),
            'currency' => 'USD',
            'shipping_amount' => $this->faker->randomFloat(2, 0, 50),
            'shipping_method' => $this->faker->word(),
            'notes' => $this->faker->sentence(),

        ];
    }
}
