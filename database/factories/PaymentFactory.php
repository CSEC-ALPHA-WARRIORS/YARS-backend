<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'registration_id' => $this->faker->numberBetween(1, 5),
            'amount' => $this->faker->numberBetween(5000, 10000),
            'paid_at' => $this->faker->dateTimeThisMonth(),
            'type' => $this->faker->randomElement(['chapa', 'manual']),
            'status' => $this->faker->randomElement(['pending', 'verified']),
            'receipt_url' => $this->faker->text()
        ];
    }
}
