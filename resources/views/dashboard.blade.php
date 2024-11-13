<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My blogs') }}
        </h2>
    </x-slot>
    <div class="py-12" x-data="data()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center gap-4">
                        <div>
                            <x-primary-button @click="open = true;">New Blog</x-primary-button>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-10">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            Slug
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            Created at
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <div class="flex items-center">
                                            Actions
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $blog->title }}
                                        </th>
                                        <td class="px-6 py-4">
                                            <a href="{{ $blog->slug }}">
                                                {{ $blog->slug }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $blog->created_at }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button
                                                class="inline-flex items-center px-4 py-2 bg-yellow-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                                @click="blogToEdit = {{ $blog }}; openEdit = true; openEditModal({{ $blog }})">
                                                Edit
                                            </button>
                                            <x-danger-button x-data @click="deleteBlog({{ $blog->id }})">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="open" x-cloak x-transition
            class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-10"
            @click.away="open = false">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden w-full max-w-lg">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Create New Blog Post') }}</h3>

                    <form>
                        <div class="mt-4">
                            <label for="title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Title') }}</label>
                            <input type="text" name="title" id="title"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200"
                                required  maxlength="50">
                        </div>

                        <div class="mt-4">
                            <label for="content"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Content') }}</label>
                            <textarea name="content" id="content" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200"
                                required  maxlength="300"></textarea>
                        </div>

                        <div class="flex flex-wrap">
                            <label for="categories"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Categories') }}</label>
                            <div class="flex items-center me-4">
                                @foreach ($categories as $category)
                                    <input id="{{ $category->name }}" type="checkbox" value="{{ $category->id }}"
                                        name="category-checkboxes"
                                        class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="{{ $category->name }}"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $category->name }}</label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button @click="open = false">{{ __('Cancel') }}</x-secondary-button>
                            <x-primary-button x-data @click="postBlog()"
                                class="ml-3">{{ __('Create') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div  x-show="openEdit" x-cloak x-transition
            class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-10"
            @click.away="openEdit = false">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden w-full max-w-lg">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Edit Blog Post') }}</h3>

                    <form>
                        <div class="mt-4">
                            <label for="title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Title') }}</label>
                            <input type="text" name="title" id="title" x-model="blogToEdit.title"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200"
                                required maxlength="50">
                        </div>

                        <div class="mt-4">
                            <label for="content"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Content') }}</label>
                            <textarea name="content" id="content" rows="4" x-model="blogToEdit.content"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200"
                                required maxlength="300"></textarea>
                        </div>
                        <div class="flex flex-wrap">
                            <label for="categories"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Categories') }}</label>
                            <div class="flex items-center me-4">
                                @foreach ($categories as $category)
                                    <input id="{{ $category->name }}" type="checkbox" value="{{ $category->id }}"
                                        name="category-checkboxes[]"
                                        class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        x-model="selectedCategories">
                                    <label for="{{ $category->name }}"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $category->name }}</label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button @click="openEdit = false">{{ __('Cancel') }}</x-secondary-button>
                            <x-primary-button @click="updateBlog(1)"
                                class="ml-3">{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


</x-app-layout>
<script>
    let selectedCategories = [];

    document.querySelectorAll('input[name="category-checkboxes"]').forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            const value = this.value;

            if (this.checked) {
                if (!selectedCategories.includes(value)) {
                    selectedCategories.push(value);
                }
            } else {
                selectedCategories = selectedCategories.filter((id) => id !== value);
            }
        });
    });

    async function postBlog() {
        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;

        await axios.post('/blogs', {
                title: title,
                content: content,
                categories: selectedCategories,
            }, {
                withCredentials: true,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            })
            .then(response => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Error creating post:', error.response ? error.response.data : error);
                alert('Failed to create the post. Please check the form inputs.');
            });
    }

    async function deleteBlog(blogId) {
        if (confirm('Are you sure you want to delete this blog?')) {
            await axios.delete(`/blogs/${blogId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    alert('Blog deleted successfully');
                    window.location.reload();
                })
                .catch(error => console.error('Error deleting blog:', error));
        }
    }

    function data() {
        return {
            open: false,
            openEdit: false,
            blogToEdit: null,
            selectedCategories: [],
            
            openEditModal(blog) {
                this.selectedCategories = blog.category_ids;
            },

            async updateBlog() {
                blog = this.blogToEdit;
                try {
                    const response = await axios.put(`/blogs/${blog.id}`, {
                        title: blog.title,
                        content: blog.content,
                        categories: this.selectedCategories,
                    });
                    window.location.reload();
                    console.log(response.data)
                } catch (error) {
                    console.error('Error fetching search results:', error);
                }
            },
        };
    }
</script>
