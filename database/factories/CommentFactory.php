<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Comment::class;

    public function definition()

    {
        
        return [
            'content' => $this->faker->paragraphs(1, true),
            'post_id' => Post::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-30 months', $endDate = 'now', $timezone = null)

        ];
    }
}
