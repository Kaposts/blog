<?php

namespace App\DataModels\Blogs;

use Spatie\LaravelData\Data;

class CreateBlogData extends Data
{
    public string $title;
    public string $content;
    public int $user_id;
    public ?array $categories;
}