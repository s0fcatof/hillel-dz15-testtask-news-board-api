<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Upvote;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $users = User::factory(10)
            ->hasPosts(3)
            ->create();

        Comment::factory(20)
            ->state(function () use ($users) {
                return [
                    'author_id' => $users->random()->id,
                    'post_id' => Post::all()->random()->id
                ];
            })
            ->create();

        Upvote::factory(20)
            ->state(function () use ($users) {
                return [
                    'user_id' => $users->random()->id,
                    'post_id' => Post::all()->random()->id
                ];
            })
            ->create();
    }
}
