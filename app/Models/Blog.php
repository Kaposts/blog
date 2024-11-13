<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blog extends Model
{
    
    public final const TABLE = 'blogs';

    public final const ID = 'id';
    public final const TITLE = 'title';
    public final const CONTENT = 'content';
    public final const USER_ID = 'user_id';
    public final const SLUG = 'slug';
    public final const CATEGORY_ID = 'category_id';

    protected $table = self::TABLE;

    protected $fillable = [
        self::TITLE,
        self::CONTENT,
        self::USER_ID,
        self::SLUG,
        self::CATEGORY_ID,
    ];

    protected $casts = [
        self::TITLE => 'string',
        self::CONTENT => 'string',
        self::USER_ID => 'integer',
        self::SLUG => 'string',
        self::CATEGORY_ID => 'integer',
    ];

    public function userRelation(): HasOne
    {
        return $this->hasOne(User::class, User::ID, self::USER_ID);
    }

    public function categoryRelation(): HasMany
    {
        return $this->hasMany(BlogCategoryPivot::class, BlogCategoryPivot::BLOG_ID, self::ID);
    }

    public function toSearchableArray()
    {
        return [
            self::TITLE => $this->title,
            self::CONTENT => $this->content,
        ];
    }
}
