<x-admin-layout>
    <div class="p-6">
        <!-- Page Title & Back Button -->
        <h2 class="text-3xl font-semibold mb-6 text-gray-800">Trashed Categories</h2>

        <!-- Back Button -->
        <div class="flex justify-end items-center mb-6">
            <a href="{{ route('admin.categories') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition shadow-md">
                <i class="fas fa-arrow-left mr-2"></i>Back to Categories
            </a>
        </div>

        <!-- Trashed Categories Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-200 text-gray-700 text-sm font-semibold">
                    <tr>
                        <th class="p-4 text-left">Image</th>
                        <th class="p-4 text-left">Category Name</th>
                        <th class="p-4 text-left">Slug</th>
                        <th class="p-4 text-left">Featured</th>
                        <th class="p-4 text-left">Deleted At</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="w-16 h-16 overflow-hidden rounded-md shadow-sm border">
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         onerror="this.onerror=null; this.src='/images/placeholder.png';" 
                                         class="object-cover w-full h-full">
                                </div>
                            </td>
                            <td class="p-4 font-medium">{{ $category->name }}</td>
                            <td class="p-4">{{ $category->slug }}</td>
                            <td class="p-4">
                                @if($category->featured)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-star text-sm mr-1"></i>
                                        Featured
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-500">{{ $category->deleted_at->format('d M Y h:i A') }}</td>
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-800 font-medium">
                                        Restore
                                    </button>
                                </form>
                                <span class="mx-2 text-gray-400">|</span>
                                <button type="button" 
                                        class="text-red-600 hover:text-red-800 font-medium delete-category-btn"
                                        data-category-id="{{ $category->id }}"
                                        data-category-name="{{ $category->name }}">
                                    Delete Permanently
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500 text-lg">
                                <i class="fas fa-trash-alt text-2xl mb-2"></i>
                                <p>No trashed categories available</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $categories->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Scripts -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function () {
        $('.delete-category-btn').on('click', function() {
            const categoryId = $(this).data('category-id');
            const categoryName = $(this).data('category-name');
            const deleteUrl = "{{ route('admin.categories.force-delete', ':id') }}".replace(':id', categoryId);

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to permanently delete "${categoryName}". This action cannot be undone!`,
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-admin-layout>