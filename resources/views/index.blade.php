<x-app-layout>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
                src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" />
            <div
                class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                    <div x-data="blogSearch()">
                        <div class="max-w-md mx-auto mt-10">
                            <input type="search" id="default-search" placeholder="Search Blogs..."
                                class="block w-full p-4 ps-10 text-sm text-gray-900 border rounded-lg"
                                @input.debounce.300ms="performSearch($event.target.value)" />
                        </div>

                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 mt-6">
                            <template x-for="blog in blogs" :key="blog.id">
                                <a :href="blog.slug"
                                    class="flex items-start gap-4 rounded-lg bg-white p-6 shadow transition duration-300 hover:text-black/70">
                                    <div class="pt-3 sm:pt-5">
                                        <h2 class="text-xl font-semibold" x-text="blog.title"></h2>
                                        <p class="mt-4 text-sm">Author: <span x-text="blog.user_relation.name"></span>
                                        </p>
                                    </div>
                                    <svg class="size-6 shrink-0 self-center stroke-red-500"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                    </svg>
                                </a>
                            </template>
                        </div>
                    </div>
                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </footer>
                </div>
            </div>
        </div>
    </body>

</x-app-layout>

</html>

<script>
    function blogSearch() {
        return {
            blogs: @json($blogs),

            async performSearch(query) {
                if (!query) {
                    this.blogs = @json($blogs);
                    return;
                }

                try {
                    const response = await axios.get('/search', {
                        params: {
                            q: query
                        }
                    });
                    this.blogs = response.data;
                    console.log(response.data)
                } catch (error) {
                    console.error('Error fetching search results:', error);
                }
            }
        };
    }
</script>
