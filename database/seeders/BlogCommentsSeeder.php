<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Blog;

class BlogCommentsSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();
        $blogIds = Blog::pluck('id')->toArray();

        if (empty($userIds) || empty($blogIds)) {
            $this->command->info('No users or blogs found in the database. Skipping comment seeding.');
            return;
        }

        foreach ($blogIds as $blogId) {
            $numberOfComments = rand(3, 5);

            for ($i = 0; $i < $numberOfComments; $i++) {
                DB::table('blog_comments')->insert([
                    'comment' => Str::random(20),
                    'user_id' => $userIds[array_rand($userIds)],
                    'blog_id' => $blogId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
