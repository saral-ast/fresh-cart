<x-admin-layout>
    <div class="p-6">
        <!-- Page Title & Add Button -->
        <h2 class="text-3xl font-semibold mb-6 text-gray-800">Products</h2>

        <!-- Search, Trash Link, and Add Category Button -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <select id="featuredFilter" class="px-8 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                    <option value="all">All Products</option>
                    <option value="featured">Featured Only</option>
                    <option value="unfeatured">Unfeatured Only</option>
                </select>
                <!-- Trash Bin Link -->
                <a href="{{ route('admin.product.trash') }}"
                   class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition shadow-md flex items-center">
                    <i class="fas fa-trash-alt mr-2"></i>Trashed Products
                </a>
            </div>
            <a href="{{ route('admin.product.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition shadow-md">
                + Add Product
            </a>
        </div>

        <!-- Products Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-200 text-gray-700 text-sm font-semibold">
                    <tr>
                        <th class="p-4 text-left">Image</th>
                        <th class="p-4 text-left">Product Name</th>
                        <th class="p-4 text-left">Category</th>
                        <th class="p-4 text-left">Price</th>
                        <th class="p-4 text-left">Featured</th>
                        <th class="p-4 text-left">Created At</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition product-row" data-featured="{{ $product->featured ? 'true' : 'false' }}">
                            <td class="p-4">
                                <div class="w-16 h-16 overflow-hidden rounded-md shadow-sm border">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         onerror="this.onerror=null; this.src='/images/placeholder.png';" 
                                         class="object-cover w-full h-full">
                                </div>
                            </td>
                            <td class="p-4 font-medium">{{ $product->name }}</td>
                            <td class="p-4">{{ $product->category ? $product->category->name : 'Uncategorized' }}</td>
                            <td class="p-4 font-semibold text-green-600">₹{{ number_format($product->price, 2) }}</td>
                            <td class="p-4">
                                @if($product->featured)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <span class="material-icons text-sm mr-1">star</span>
                                        Featured
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-500">{{ $product->created_at->format('d M Y h:i A') }}</td>
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.product.edit', $product->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Edit
                                </a>
                                <span class="mx-2 text-gray-400">|</span>
                                <button data-modal-target="popup-modal" 
                                        data-modal-toggle="popup-modal" 
                                        type="button" 
                                        class="text-red-600 hover:text-red-800 font-medium"
                                        data-product-id="{{ $product->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500 text-lg">No products available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $products->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
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
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Are you sure you want to delete this Product?</h3>
                    <form action="{{ route('admin.product.destroy', '') }}" method="POST" class="inline-block ml-3" id="deleteProductForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, I'm sure
                        </button>
                    </form>
                    <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @push('scripts')
    <script>
    $(document).ready(function () {
        $('button[data-modal-toggle="popup-modal"]').click(function() {
            const productId = $(this).data('product-id');
            const form = $('#deleteProductForm');
            const action = form.attr('action');
            form.attr('action', `${action}/${productId}`);
        });

        $('#featuredFilter').on('change', function() {
            const filterValue = $(this).val();
            const rows = $('.product-row');

            rows.each(function() {
                const featuredAttr = $(this).data('featured');
                const isFeatured = featuredAttr === true || featuredAttr === 'true';
                
                switch(filterValue) {
                    case 'featured':
                        $(this).toggle(isFeatured);
                        break;
                    case 'unfeatured':
                        $(this).toggle(!isFeatured);
                        break;
                    default: // 'all'
                        $(this).show();
                        break;
                }
            });
        });
    });
    </script>
    @endpush    

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-admin-layout>