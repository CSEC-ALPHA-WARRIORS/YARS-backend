<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Students;

class StudentsSeeder extends Seeder
{
    public function run(): void
    {
        Students::factory()
            ->count(5)
            ->create();
    }
}
