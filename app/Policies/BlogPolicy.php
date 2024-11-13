<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    final public const BLOGS_UPDATE_OWN = 'blogs_update_own';
    final public const BLOGS_DELETE_OWN = 'blogs_delete_own';
    final public const BLOGS_COMMENT_DELETE_OWN = 'blogs_comment_delete_own';

    public function __construct(
        private readonly User $userModel,
        private readonly Blog $blogModel,
        private readonly BlogComment $blogCommentModel,
        )
    {
    }

    public function blogUpdateOwn(User $user, int $blogId): bool 
    {
        return $user->id === $this->blogModel->findOrFail($blogId)->user_id;
    }

    public function blogDeleteOwn(User $user, int $blogId): bool 
    {
        return $user->id === $this->blogModel->findOrFail($blogId)->user_id;
    }

    public function blogsCommentDeleteOwn(User $user, int $commentId): bool 
    {
        return $user->id === $this->blogCommentModel->findOrFail($commentId)->user_id;
    }
}
