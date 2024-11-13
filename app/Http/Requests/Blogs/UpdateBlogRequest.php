<?php

namespace App\Http\Requests\Blogs;

use App\DataModels\Blogs\UpdateBlogData;
use App\Models\Blog;
use App\Policies\BlogPolicy;
use App\Rules\RulesHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\Access\Gate;

class UpdateBlogRequest extends FormRequest
{
    private const BLOG_ID = 'blog_id';
    private const TITLE = 'title';
    private const CONTENT = 'content';
    private const CATEGORIES = 'categories';

    public function authorize(Gate $gate): bool
    {
        return $gate->allows(BlogPolicy::BLOGS_UPDATE_OWN, $this->getBlogId());
    }

    public function rules(): array
    {
        return [
            self::BLOG_ID => [
                RulesHelper::REQUIRED,
                RulesHelper::INT,
                RulesHelper::existsOnDatabase(Blog::TABLE, Blog::ID)
            ],
            self::TITLE => [
                RulesHelper::REQUIRED,
                RulesHelper::STRING,
            ],
            self::CONTENT => [
                RulesHelper::REQUIRED,
                RulesHelper::STRING,
            ],
            self::CATEGORIES => [
                RulesHelper::NULLABLE,
                RulesHelper::ARRAY,
            ],
        ];
    }

    public function data(): UpdateBlogData
    {
        return UpdateBlogData::from($this->validated());
    }

    public function getBlogId(): int
    {
        return (int)$this->route(self::BLOG_ID);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            self::BLOG_ID => $this->getBlogId(),
        ]);
    }
}
