<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Post::factory()->count(50)->create();
        \App\Models\Author::factory()->count(20)->create();

        $posts = \App\Models\Post::all();
        $authors = \App\Models\Author::all();

        $posts->each(function ($post) use ($authors) {
            // 將隨機 1~3 個 author attach 關聯至 post
            $post->authors()->attach($authors->random(rand(1, 3))->pluck('id')->toArray());
        });

    }
}
