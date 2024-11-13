<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    
    public final const TABLE = 'blog_categories';

    public final const ID = 'id';
    public final const NAME = 'name';
    public final const SLUG = 'slug';
    public final const DESCRIPTION = 'description';

    protected $table = self::TABLE;

    protected $fillable = [
        self::NAME,
        self::SLUG,
        self::DESCRIPTION,
    ];
}
