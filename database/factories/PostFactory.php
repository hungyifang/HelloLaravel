<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText($maxNbChars = 30),
            'subtitle' => $this->faker->realText($maxNbChars = 30),
            'description' => $this->faker->text($maxNbChars = 200),
            'available' => true,
            'likes' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
