<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => PaymentStatus::NEW,
            'amount' => 2300,
        ];
    }
}
