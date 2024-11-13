<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-app-layout class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" />

        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <main class="mt-6">
                    <div
                        class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                        <div class="sm:pt-5 size-full" style="width:100%">
                            <h2 class="text-xl font-semibold text-black dark:text-white">{{ $blog->title }}</h2>

                            <p class="mt-4">
                                {{ $blog->content }}
                            </p>

                            <p class="mt-4 text-m/relaxe" style="text-align:right">
                                Author: {{ $blog->userRelation->name }}
                            </p>
                            <p class="text-sm/relaxe" style="text-align:right">
                                {{ $blog->created_at }}
                            </p>
                        </div>
                    </div>

                    <form class="mt-5">
                        <div
                            class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                                <label for="comment" class="sr-only">Your comment</label>
                                <textarea id="comment" rows="4"
                                    class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Write a comment..." required maxlength="300"></textarea>
                            </div>
                            <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                                <button
                                    class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800"
                                    x-data @click="postComment({{ $blog->id }})">
                                    Post comment
                                </button>
                            </div>
                        </div>
                    </form>
                    <p class="ms-auto text-xs text-gray-500 dark:text-gray-400">Remember, contributions to this topic
                        should follow our <a href="#"
                            class="text-blue-600 dark:text-blue-500 hover:underline">Community Guidelines</a>.</p>


                    @foreach ($comments as $comment)
                        <div class="flex items-start gap-2.5 mt-5">
                            <img class="w-8 h-8 rounded-full"
                                src="https://www.transparentpng.com/thumb/user/gray-user-profile-icon-png-fP8Q1P.png"
                                alt="Jese image">
                            <div
                                class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span
                                        class="text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->userRelation->name }}</span>
                                    <span
                                        class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $comment->created_at }}</span>
                                </div>
                                <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">
                                    {{ $comment->comment }}</p>
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400"></span>
                            </div>
                            @auth
                                @if (Auth::user()->id === $comment->userRelation->id)
                                    <button x-data @click="deleteComment({{$comment->id}})" type="button"
                                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                                @endif
                            @endauth
                        </div>
                    @endforeach

                </main>
                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
            </div>
        </div>
    </div>
</x-app-layout>

</html>

<script>
    async function postComment(blogId) {
        const comment = document.getElementById('comment').value;

        await axios.post('/blogs/comment', {
                comment: comment,
                blog_id: blogId,
            }, {
                withCredentials: true,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                window.location.reload();
            })
            .catch(error => {
                if (error.status === 401) {
                    window.location.href = "{{ route('login') }}";
                }
                console.error('Error posting comment:', error);
            });
    };

    async function deleteComment(commentId) {
        await axios.delete(`/blogs/comment/${commentId}`, {}, {
                withCredentials: true,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Error deleting comment:', error);
            });
    };
</script>
