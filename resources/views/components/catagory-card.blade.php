@props(['category'])
    <div class="bg-white shadow-sm rounded-lg p-4 flex flex-col w-full h-auto items-center border border-gray-200 hover:border-green-400 hover:shadow-2xl transition-all duration-400">
        <img src="{{ asset('storage/' . $category->image) }}" 
                 onerror="this.onerror=null; this.src='/images/placeholder.png';" 
                 alt="{{ $category->name }}" 
                 class="w-32 h-32 md:w-40 md:h-40 object-contain hover:scale-110 transition-all duration-300">
        <p class="text-gray-700 text-sm font-medium mt-2 text-center">{{ $category->name }}</p>
    </div>
  



