<?php

namespace App\DataModels\Blogs;

use Spatie\LaravelData\Data;

class UpdateBlogData extends Data
{
    public int $blog_id;
    public string $title;
    public string $content;
    public array $categories;
}