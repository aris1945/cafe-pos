<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        
        return [
            'category_id' => \App\Models\Category::inRandomOrder()->first()?->id ?? 1,
            'name' => ucwords($name),
            'slug' => str($name)->slug(),
            'description' => 'Menu andalan kami: ' . $this->faker->sentence(),
            'price' => $this->faker->numberBetween(10, 50) * 1000,
            'image' => 'https://picsum.photos/seed/'.rand(1,9999).'/400/300',
            'is_active' => true,
        ];
    }
}
