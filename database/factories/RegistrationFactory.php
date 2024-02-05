<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Registration;

class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition(): array
    {
        return [
            'student_id' => $this->faker->numberBetween(1, 5),
            'year' => $this->faker->numberBetween(2010, 2024),
            'semester' => $this->faker->numberBetween(1, 2),
            'program' => $this->faker->randomElement(['Software Engineering', 'Computer Science and Engineering']),
            'status' => $this->faker->randomElement(['pending', 'verified']),
            'level' => $this->faker->randomElement(['BSC', 'MSC']),
            'registered_at' => $this->faker->dateTimeThisMonth()
        ];
    }
}
