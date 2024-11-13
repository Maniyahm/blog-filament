<!-- resources/views/filament/widgets/latest-blogs.blade.php -->

<x-filament::widget>
    <x-filament::card>
        <h2 class="text-xl font-semibold mb-4">Latest Blogs</h2>
        <ul>
            @foreach ($this->latestBlogs as $blog)
                <li class="mb-2">
                    <a href="{{ route('blog.view', $blog) }}" class="text-blue-600 hover:underline">
                        {{ $blog->title }}
                    </a>
                    <span class="text-gray-500 text-sm">
                        - {{ $blog->created_at->format('M d, Y') }}
                    </span>
                </li>
            @endforeach
        </ul>
    </x-filament::card>
</x-filament::widget>
