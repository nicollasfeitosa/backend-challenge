<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-2 month', 'now');

        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'type' => $this->faker->randomElement(['debit', 'credit', 'refund']),
            'amount' => $this->faker->randomFloat(2, 0, 900),
            'created_at' => $date,
            'updated_at' => $date
        ];
    }

}
