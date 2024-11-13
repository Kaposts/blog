<?php

namespace App\DataModels\Blogs;

use Spatie\LaravelData\Data;

class CreateBlogCommentData extends Data
{
    public string $comment;
    public int $blog_id;
    public int $user_id;
}