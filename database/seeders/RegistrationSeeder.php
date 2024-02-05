<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Registration;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        Registration::factory()
            ->count(5)
            ->create();
    }
}
