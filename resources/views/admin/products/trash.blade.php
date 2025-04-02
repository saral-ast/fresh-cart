<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="material-icons mr-2 text-gray-600">delete</span>
                Trashed Products
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.product.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-all">
                    <span class="material-icons mr-2 text-sm">arrow_back</span>
                    Back to Products
                </a>
            </div>
        </div>

        <!-- Trashed Products Table -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm">
                            <th class="px-6 py-4 text-left font-semibold">Image</th>
                            <th class="px-6 py-4 text-left font-semibold">Product Name</th>
                            <th class="px-6 py-4 text-left font-semibold">Category</th>
                            <th class="px-6 py-4 text-left font-semibold">Price</th>
                            <th class="px-6 py-4 text-left font-semibold">Featured</th>
                            <th class="px-6 py-4 text-left font-semibold">Deleted At</th>
                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-16 h-16 overflow-hidden rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         onerror="this.onerror=null; this.src='/images/placeholder.png';" 
                                         class="object-cover w-full h-full">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $product->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-600">{{ $product->category ? $product->category->name : 'Uncategorized' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-green-600">₹{{ number_format($product->price, 2) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->featured)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <span class="material-icons text-xs mr-1">star</span>
                                        Featured
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-500">{{ $product->deleted_at->format('d M Y h:i A') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.product.restore', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-800 font-medium inline-flex items-center">
                                        <span class="material-icons text-sm mr-1">restore</span>
                                        Restore
                                    </button>
                                </form>
                                <button type="button" 
                                        class="text-red-600 hover:text-red-800 font-medium delete-product-btn inline-flex items-center"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}">
                                        <span class="material-icons text-sm mr-1">delete_forever</span>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <span class="material-icons text-gray-400 text-4xl mb-3">delete</span>
                                    <p class="text-lg">No trashed products available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Scripts -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function () {
        $('.delete-product-btn').on('click', function() {
            const productId = $(this).data('product-id');
            const productName = $(this).data('product-name');
            const deleteUrl = "{{ route('admin.product.force-delete', ':id') }}".replace(':id', productId);

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to permanently delete "${productName}". This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a temporary form to submit the DELETE request
                    const form = $('<form>', {
                        'method': 'POST',
                        'action': deleteUrl
                    }).append(
                        $('<input>', {
                            'type': 'hidden',
                            'name': '_token',
                            'value': '{{ csrf_token() }}'
                        }),
                        $('<input>', {
                            'type': 'hidden',
                            'name': '_method',
                            'value': 'DELETE'
                        })
                    );

                    $('body').append(form);
                    form.submit();
                }
            });
        });
    });
    </script>
    @endpush    

</x-admin-layout>