<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        $fname = $this->faker->name();
        $lname = $this->faker->name();

        return [
            'fname' => $fname,
            'mname' => $this->faker->name(),
            'lname' => $lname,
            'email' => $this->faker->safeEmail(),
            'phonenumber' => $this->faker->phoneNumber(),
            'password' => $fname.$lname,
            'role' => $this->faker->randomElement(['registrar_employee', 'registrar_head'])
        ];
    }
}
