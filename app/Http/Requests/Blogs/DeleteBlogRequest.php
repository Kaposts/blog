<?php

namespace App\Http\Requests\Blogs;

use App\Policies\BlogPolicy;
use App\Rules\RulesHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\Access\Gate;

class DeleteBlogRequest extends FormRequest
{
    private const BLOG_ID = 'blog_id';

    public function authorize(Gate $gate): bool
    {
        return $gate->allows(BlogPolicy::BLOGS_DELETE_OWN, $this->getBlogId());
    }

    public function rules(): array
    {
        return [
            self::BLOG_ID => [
                RulesHelper::REQUIRED,
                RulesHelper::INT,
            ]
        ];
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
