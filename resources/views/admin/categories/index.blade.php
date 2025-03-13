<x-admin-layout>
    <div class="p-10">
        <!-- Page Title -->
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Categories</h2>

        <!-- Search and Add Category Button -->
        <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md">
            <div></div> <!-- Placeholder for future search functionality -->
            <a href="{{ route('admin.categories.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-semibold transition">
                + Add Category
            </a>
        </div>

        <!-- Categories Table -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr class="text-gray-700">
                        <th class="px-6 py-3 text-left font-semibold">Name</th>
                        <th class="px-6 py-3 text-left font-semibold">Slug</th>
                        <th class="px-6 py-3 text-left font-semibold">Image</th>
                        <th class="px-6 py-3 text-center font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-gray-900">{{ $category->name }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $category->slug }}</td>
                            
                            <!-- Image with Fallback -->
                            <td class="px-6 py-3">
                                <div class="w-16 h-16 overflow-hidden border rounded-lg shadow-sm">
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         onerror="this.onerror=null; this.src='/images/placeholder.png';" 
                                         alt="Category Image" 
                                         class="object-cover w-full h-full">
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('admin.categories.edit', $category->slug) }}" 
                                   class="text-blue-500 hover:underline font-medium">Edit</a>

                                <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button" class="text-red-500 hover:underline font-medium" data-category-slug="{{ $category->slug }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    

    
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Are you sure you want to delete this Category?</h3>
                      <form action="{{ route('admin.categories.destroy', '') }}" method="POST" class="inline-block ml-3" id="deleteCategoryForm">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                              Yes, I'm sure
                          </button>
                      </form>
                    </form>
                    <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
     <script>
    $(document).ready(function () {
    $('.text-red-500[data-modal-toggle="popup-modal"]').click(function() {
        const categorySlug = $(this).data('category-slug');
        const form = $('#deleteCategoryForm');
        const action = form.attr('action').replace(/\/$/, ''); // Ensure no trailing slash
        form.attr('action', `${action}/${categorySlug}`);
    });
});

     </script>
        
    @endpush    
</x-admin-layout>
