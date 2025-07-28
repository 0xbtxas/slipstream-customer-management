<?php

namespace Database\Factories;


use App\Models\Customer;
use App\Models\CustomerCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'reference' => strtoupper($this->faker->bothify('REF###??')),
            'customer_category_id' => CustomerCategory::factory(),
            'start_date' => $this->faker->date(),
            'description' => $this->faker->sentence,
        ];
    }
}
