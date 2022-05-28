<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'initialBalance' => 100,
            'password' => bcrypt('123mudar'),
        ]);

        User::factory()->count(10)->create();

        Transaction::factory()->count(50)->create();
    }
}
