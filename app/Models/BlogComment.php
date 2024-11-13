<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogComment extends Model
{
    public final const TABLE = 'blog_comments';

    public final const ID = 'id';
    public final const COMMENT = 'comment';
    public final const BLOG_ID = 'blog_id';
    public final const USER_ID = 'user_id';

    protected $table = self::TABLE;

    protected $fillable = [
        self::COMMENT,
        self::BLOG_ID,
        self::USER_ID,
    ];

    public function userRelation(): HasOne
    {
        return $this->hasOne(User::class, User::ID, self::USER_ID);
    }
}
