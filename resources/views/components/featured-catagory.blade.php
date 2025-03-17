@props(['categories' => $featuredCategories])
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @foreach ($categories as $category)
        <div class="bg-white shadow-sm rounded-lg p-4 flex flex-col w-full h-auto items-center border border-gray-200 hover:border-green-400 hover:shadow-2xl transition-all duration-400">
            <!-- Increased width & height -->
            <img src="{{ asset('storage/' . $category['image'])}}" 
                 alt="{{ $category['name'] }}" 
                 class="w-32 h-32 md:w-40 md:h-40 object-contain hover:scale-110 transition-all duration-300">
            <p class="text-gray-700 text-sm font-medium mt-2 text-center">{{ $category['name'] }}</p>
        </div>
    @endforeach
</div>