<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();
        $articles = \App\Models\Article::all();

        $articles->each(function ($article) use ($users) {
            // 將隨機 1~3 個 user attach 關聯至 userlike
            $article->likes()->attach($users->random(rand(1, 3))->pluck('id')->toArray(), ['doLike' => true]);
        });

    }
}
