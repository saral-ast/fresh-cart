<x-layout>
    {{-- <section class="py-8 bg-white md:py-16 antialiased"> --}}
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 mb-3">
            <div class="bg-gray-100 px-6 py-10 rounded-lg"> <!-- Increased padding -->
                <h3 class="text-2xl font-bold text-gray-900">All Categories</h3>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
            @foreach ($categories as $category)
            <a href="{{ route('user.category.show', $category->slug) }}">
                <x-catagory-card :category="$category" />
            </a>    
            @endforeach
        </div>
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
     
    {{-- </section> --}}
</x-layout>
