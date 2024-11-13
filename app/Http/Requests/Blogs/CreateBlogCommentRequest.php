<?php

namespace App\Http\Requests\Blogs;

use App\DataModels\Blogs\CreateBlogCommentData;
use App\Models\Blog;
use App\Rules\RulesHelper;
use Illuminate\Foundation\Http\FormRequest;

class CreateBlogCommentRequest extends FormRequest
{
    private const COMMENT = 'comment';
    private const BLOG_ID = 'blog_id';

    public function rules(): array
    {
        return [
            self::COMMENT => [
                RulesHelper::REQUIRED,
                RulesHelper::STRING,
            ],
            self::BLOG_ID => [
                RulesHelper::REQUIRED,
                RulesHelper::INT,
                RulesHelper::existsOnDatabase(Blog::TABLE, Blog::ID)
            ],
        ];
    }

    public function data(): CreateBlogCommentData
    {
        return CreateBlogCommentData::from(array_merge($this->validated(), ['user_id' => $this->user()->id]));
    }
}
