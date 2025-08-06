<?php

namespace Database\Seeders;

use App\Models\SavedPost;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavedPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users and posts for seeding
        $users = User::take(5)->get();
        $posts = Post::take(10)->get();

        if ($users->isEmpty() || $posts->isEmpty()) {
            $this->command->info('No users or posts found. Skipping SavedPost seeding.');
            return;
        }

        // Create some saved posts
        foreach ($users as $user) {
            // Each user saves 2-4 random posts
            $randomPosts = $posts->random(rand(2, 4));
            
            foreach ($randomPosts as $post) {
                SavedPost::firstOrCreate([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
        }

        $this->command->info('SavedPost seeding completed successfully!');
    }
}
