<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->pluck('id');

        foreach ($users as $user) {
            $blogCount = rand(1, 3);

            for ($i = 0; $i < $blogCount; $i++) {
                DB::table('blogs')->insert([
                    'title' => 'Blog Title ' . Str::random(5),
                    'content' => 'This is the content of the blog post ' . Str::random(20),
                    'slug' => Str::slug('Blog Title ' . Str::random(5) . '-' . time()),
                    'user_id' => $user,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
