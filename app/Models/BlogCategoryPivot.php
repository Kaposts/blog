<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategoryPivot extends Model
{
    public final const TABLE = 'blog_category_pivot';

    public final const BLOG_ID = 'blog_id';
    public final const CATEGORY_ID = 'category_id';

    protected $table = self::TABLE;

    protected $fillable = [
        self::BLOG_ID,
        self::CATEGORY_ID,
    ];
    
    public $timestamps = false;
}
