<?php

namespace App\Http\Requests\Blogs;

use App\Models\BlogComment;
use App\Policies\BlogPolicy;
use App\Rules\RulesHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\Access\Gate;

class DeleteBlogCommentRequest extends FormRequest
{
    private const COMMENT_ID = 'comment_id';

    public function authorize(Gate $gate): bool
    {
        return $gate->allows(BlogPolicy::BLOGS_COMMENT_DELETE_OWN, $this->getCommentId());
    }

    public function rules(): array
    {
        return [
            self::COMMENT_ID => [
                RulesHelper::REQUIRED,
                RulesHelper::INT,
                RulesHelper::existsOnDatabase(BlogComment::TABLE, BlogComment::ID)
            ],
        ];
    }

    public function getCommentId(): int
    {
        return (int)$this->route(self::COMMENT_ID);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            self::COMMENT_ID => $this->getCommentId(),
        ]);
    }
}
