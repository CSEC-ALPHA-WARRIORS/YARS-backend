<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        $fname = explode(' ', $this->faker->name())[0];
        $lname = explode(' ', $this->faker->name())[0];

        return [
            'fname' => $fname,
            'mname' => explode(' ', $this->faker->name())[0],
            'lname' => $lname,
            'email' => $this->faker->safeEmail(),
            'phonenumber' => $this->faker->phoneNumber(),
            'password' => password_hash($fname.$lname, PASSWORD_DEFAULT),
            'role' => $this->faker->randomElement(['registrar_employee', 'registrar_head'])
        ];
    }
}
