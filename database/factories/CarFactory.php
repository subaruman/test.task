<?php

namespace Database\Factories;

use App\Models\{Car, User};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    private string $brand;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'brand' => $this->getRandBrand(),
            'model' => $this->getRandModel(),
            'year_issue' => $this->faker->year(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Get random brand
     */
    private function getRandBrand(): string
    {
        return $this->brand = array_rand_val(Car::BRANDS);
    }

    /**
     * Get random model of brand
     */
    private function getRandModel(): string
    {
        if ($this->brand) {
            $const = '::MODELS_' . mb_strtoupper($this->brand);

            return array_rand_val(constant(Car::class . $const));
        }

        return array_rand_val(Car::MODELS);
    }
}
