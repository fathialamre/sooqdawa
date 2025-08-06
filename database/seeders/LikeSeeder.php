<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all posts and users
        $posts = Post::all();
        $users = User::whereType('customer')->get();

        if ($posts->isEmpty()) {
            $this->command->error('Please run PostSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->error('Please run CustomerSeeder first.');
            return;
        }

        $likesCreated = 0;

        // Create likes for each post (30%-80% of users will like each post)
        foreach ($posts as $post) {
            // Randomly select 30% to 80% of users to like this post
            $likePercentage = rand(30, 80) / 100;
            $usersToLike = $users->random((int)($users->count() * $likePercentage));
            
            foreach ($usersToLike as $user) {
                // Check if this user already liked this post to avoid duplicates
                $existingLike = Like::where('post_id', $post->id)
                    ->where('user_id', $user->id)
                    ->first();
                
                if (!$existingLike) {
                    Like::create([
                        'post_id' => $post->id,
                        'user_id' => $user->id,
                        'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                    ]);
                    
                    $likesCreated++;
                }
            }
        }

        $this->command->info("Like seeder completed successfully! Created {$likesCreated} likes for " . $posts->count() . " posts.");
    }
}