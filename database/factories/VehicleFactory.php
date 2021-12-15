<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
    
            'maker' => $this->faker->word,
            'model' => $this->faker->word,
            'year'=>$this->faker->year(),
            'front_image' => $this->faker->imageUrl(),
            'back_photo' => $this->faker->imageUrl(),
            'mileage' => $this->faker->numberBetween(0, 1000),
            'license_plate' => $this->faker->word,
            'color' => $this->faker->colorName,
            'is_active' => (int) $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
