<?php

namespace App\Repository\Blogs;

use App\DataModels\Blogs\CreateBlogCommentData;
use App\DataModels\Blogs\CreateBlogData;
use App\DataModels\Blogs\UpdateBlogData;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogCategoryPivot;
use App\Models\BlogComment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BlogRepository 
{
    public function __construct(
        private readonly Blog $blogModel,
        private readonly BlogCategory $blogCategoryModel,
        private readonly BlogComment $blogCommentModel,
        private readonly BlogCategoryPivot $blogCategoryPivotModel,
    )
    {
    }

    public function getBlogs(): Collection
    {
        return $this->blogModel
            ->with('userRelation')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getBlogsByUserId(int $userId): Collection
    {
        $blogs = $this->blogModel->where('user_id', '=', $userId)->with('categoryRelation')->orderBy('created_at', 'desc')->get();

        $blogs->each(function ($blog) {
            $blog->category_ids = $blog->categoryRelation->pluck('category_id')->toArray();
        });

        return $blogs;
    }

    public function getBlogBySlug(string $blogSlug): ?Blog
    {
        return $this->blogModel
            ->where(Blog::SLUG, '=', $blogSlug)
            ->first();
    }

    public function store(CreateBlogData $data): Blog
    {
        $slug = Str::slug($data->title,'-');
        
        $blog = Blog::create(array_merge($data->toArray(), ['slug' => $slug]));

        foreach ($data->categories as $categoryId) {
            $this->blogCategoryPivotModel->create([
                'blog_id' => $blog->id,
                'category_id' => $categoryId
            ]);
        };

        return $blog;
    }

    public function update(UpdateBlogData $data): JsonResponse
    {
        $slug = Str::slug($data->title,'-');

        $blog = Blog::findOrFail($data->blog_id);
        $blog->update(array_merge($data->toArray(), ['slug' => $slug]));

        $this->blogCategoryPivotModel->where(BlogCategoryPivot::BLOG_ID, '=', $data->blog_id)->delete();
        foreach ($data->categories as $categoryId) {
            $this->blogCategoryPivotModel->create([
                'blog_id' => $blog->id,
                'category_id' => $categoryId
            ]);
        };

        return response()->json([
            'message' => 'Blog updated successfully',
            'data' => $blog
        ]); 
    }

    public function delete(int $blogId): JsonResponse
    {
        $blog = $this->blogModel->findOrFail($blogId);
        $this->blogCategoryPivotModel->where(BlogCategoryPivot::BLOG_ID, '=', $blogId)->delete();
        $blog->delete();

        return response()->json([
            'message' => 'Blog deleted successfully'
        ]);
    }

    public function createBlogComment(CreateBlogCommentData $data): BlogComment
    {
        $comment = $this->blogCommentModel->create($data->toArray());

        return $comment;
    }

    public function deleteBlogComment(int $commentId): JsonResponse
    {
        $this->blogCommentModel->findOrFail($commentId)->delete();

        return response()->json([
            'message' => 'Blog deleted successfully'
        ]);
    }

    public function getCommentsByBlogId(int $blogId): Collection
    {
        return $this->blogCommentModel
            ->where(BlogComment::BLOG_ID, '=', $blogId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getCategories(): Collection
    {
        return $this->blogCategoryModel->all();
    }
}