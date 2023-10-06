<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Post::class;
    
    public function definition()
    {
        $title = $this->faker->sentence;
        $userId = User::inRandomOrder()->first()->id;
        $tagId = Tag::inRandomOrder()->first()->id;
        return [
            'title' => $title,
            'content' => $this->faker->paragraphs(2,true),
            'slug' => Str::slug($title),
            'active' => $this->faker->boolean,
            'user_id' => $userId,
            'tag_id' => $tagId,
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-30 months', $endDate = 'now', $timezone = null)

            
        ];
    }
}
