<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Faker\Generator as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomUser = User::inRandomOrder()->first();

        return [
            'user_id'=>  User::query()->inRandomOrder()->first()->id,
            'seller_name' => $this->faker->company,
            'seller_invoice_number' => $this->faker->unique()->randomNumber(4),
            'shipment_number' => $this->faker->unique()->randomNumber(5),
            'invoice_amount' => $this->faker->randomFloat(2, 50, 500),
            'status' => $this->faker->randomElement(['pending', 'confirmed']),
        ];
    }
}
