<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MuridSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'murid@example.com'],
            [
                'name' => 'Murid Contoh',
                'role' => 'murid',
                'password' => bcrypt('password'),
            ]
        );
    }
}
