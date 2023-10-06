<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\User;
use Database\Factories\PostTagFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Tag::factory(10)->create();
        Post::factory()->count(30)->create();
        Comment::factory()->count(100)->create();

        $this->call([
            PostTagSeeder::class
        ]);
        

        
        


    }
}

