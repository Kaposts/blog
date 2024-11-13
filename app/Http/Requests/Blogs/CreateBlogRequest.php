<?php

namespace App\Http\Requests\Blogs;

use App\DataModels\Blogs\CreateBlogData;
use App\Models\BlogCategory;
use App\Rules\RulesHelper;
use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
{
    private const TITLE = 'title';
    private const CONTENT = 'content';
    private const CATEGORIES = 'categories';

    public function rules(): array
    {
        return [
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

    public function data(): CreateBlogData
    {
        return CreateBlogData::from(array_merge($this->validated(), ['user_id' => $this->user()->id]));
    }
}
