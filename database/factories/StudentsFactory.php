<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Students;

class StudentsFactory extends Factory
{
    protected $model = Students::class;

    public function definition(): array
    {
        $fname = $this->faker->name();
        $lname = $this->faker->name();

        return [
            'fname' => $fname,
            'mname' => $this->faker->name(),
            'lname' => $lname,
            'profile_picture_url' => $this->faker->text(),
            'email' => $this->faker->safeEmail(),
            'phonenumber' => $this->faker->phoneNumber(),
            'password' => $fname.$lname,
            'type' => $this->faker->randomElement(['Regular', 'Extension'])
        ];
    }
}
