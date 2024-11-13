<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blogs\CreateBlogCommentRequest;
use App\Http\Requests\Blogs\CreateBlogRequest;
use App\Http\Requests\Blogs\DeleteBlogCommentRequest;
use App\Http\Requests\Blogs\DeleteBlogRequest;
use App\Http\Requests\Blogs\UpdateBlogRequest;
use App\Models\Blog;
use App\Repository\Blogs\BlogRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function __construct(private readonly BlogRepository $blogRepository)
    {
    }

    public function index(): View
    {
        $blogs = $this->blogRepository->getBlogs();

        return view('index', compact('blogs'));
    }

    public function dashboard(): View
    {
        $blogs = $this->blogRepository->getBlogsByUserId(Auth::user()->id);

        $categories = $this->blogRepository->getCategories();

        return view('dashboard', compact('blogs'), compact('categories'));
    }

    public function blog(string $blogSlug): View
    {
        $blog = $this->blogRepository->getBlogBySlug($blogSlug);
        $comments = $this->blogRepository->getCommentsByBlogId($blog->id);
        
        return view('blog', compact('blog'), compact('comments'));
    }

    public function store(CreateBlogRequest $request): JsonResponse
    {
        $this->blogRepository->store($request->data());
        
        return response()->json([], Response::HTTP_CREATED);
    }

    public function update(UpdateBlogRequest $request): JsonResponse
    {
        $response = $this->blogRepository->update($request->data());
        
        return response()->json($response);
    }

    public function destroy(DeleteBlogRequest $request): JsonResponse
    {
        $response = $this->blogRepository->delete($request->getBlogId());

        return response()->json($response);
    }

    public function comment(CreateBlogCommentRequest $request): JsonResponse
    {
        $this->blogRepository->createBlogComment($request->data());

        return response()->json([], Response::HTTP_CREATED);
    }

    public function deleteComment(DeleteBlogCommentRequest $request): JsonResponse
    {
        return $this->blogRepository->deleteBlogComment($request->getCommentId());
    }

    public function searchBlog(Request $request): Collection
    {
        $query = $request->query->get('q');

        return Blog::where('title', 'like', '%' . $query . '%')
        ->orWhere('content', 'like', '%' . $query . '%')
        ->with('userRelation')
        ->get();
    }
}
