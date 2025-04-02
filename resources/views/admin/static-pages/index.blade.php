<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="material-icons mr-2 text-gray-600">description</span>
                Static Pages Management
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.static-pages.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-all shadow-sm">
                    <span class="material-icons mr-2 text-sm">add</span>
                    Add New Page
                </a>
                <!-- Uncomment and set route if implementing soft deletes -->
                <!-- <a href" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-all">
                    <span class="material-icons mr-2 text-sm">delete_outline</span>
                    Trash
                </a> -->
            </div>
        </div>

        <!-- Filters & Stats Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <!-- Filter Controls -->
                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <select id="statusFilter" class="pl-10 pr-4 py-2.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition-all appearance-none">
                            <option value="all">All Pages</option>
                            <option value="active">Active Only</option>
                            <option value="inactive">Inactive Only</option>
                        </select>
                        <span class="material-icons absolute left-3 top-2.5 text-gray-500">filter_list</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Static Pages Table -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm">
                            <th class="px-6 py-4 text-left font-semibold">
                                <span class="flex items-center">
                                    <span class="material-icons text-xs mr-1">title</span> Title
                                </span>
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <span class="flex items-center">
                                    <span class="material-icons text-xs mr-1">link</span> Slug
                                </span>
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <span class="flex items-center">
                                    <span class="material-icons text-xs mr-1">toggle_on</span> Status
                                </span>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold">
                                <span class="flex items-center justify-center">
                                    <span class="material-icons text-xs mr-1">settings</span> Actions
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($staticPages as $page)
                            <tr class="hover:bg-gray-50/50 transition-colors page-row" data-active="{{ $page->is_active ? 'true' : 'false' }}">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $page->title }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-500">{{ $page->slug }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($page->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="material-icons text-xs mr-1">check_circle</span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <span class="material-icons text-xs mr-1">cancel</span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.static-pages.edit', $page) }}" 
                                           class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors flex items-center">
                                            <span class="material-icons text-sm mr-1">edit</span>
                                            Edit
                                        </a>
                                        <a href="{{ route('page', $page->slug) }}" target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors flex items-center">
                                            <span class="material-icons text-sm mr-1">visibility</span>
                                            View
                                        </a>
                                        <button data-modal-target="popup-modal" 
                                                data-modal-toggle="popup-modal" 
                                                type="button" 
                                                class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors flex items-center"
                                                data-page-id="{{ $page->id }}">
                                            <span class="material-icons text-sm mr-1">delete</span>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <span class="material-icons text-gray-400 text-4xl mb-3">description</span>
                                    <p class="text-lg">No static pages available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $staticPages->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-lg">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="h-16 w-16 rounded-full bg-red-50 flex items-center justify-center">
                            <span class="material-icons text-red-500 text-2xl">delete_forever</span>
                        </div>
                    </div>
                    <h3 class="mb-1 text-xl font-semibold text-gray-800">Delete Static Page</h3>
                    <p class="mb-6 text-gray-500">Are you sure you want to delete this page? This action cannot be undone.</p>
                    <div class="flex justify-center gap-3">
                        <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                            Cancel
                        </button>
                        <form action="{{ route('admin.static-pages.destroy', '') }}" method="POST" class="inline-block" id="deletePageForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                <span class="material-icons text-sm mr-1">check</span>
                                Yes, I'm sure
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @push('scripts')
    <script>
    $(document).ready(function () {
        // Modal handling for delete button
        $('button[data-modal-toggle="popup-modal"]').click(function() {
            const pageId = $(this).data('page-id');
            const form = $('#deletePageForm');
            const baseAction = "{{ route('admin.static-pages.destroy', '') }}";
            form.attr('action', `${baseAction.replace(/\/$/, '')}/${pageId}`);
        });

        // Filter handling
        $('#statusFilter').on('change', function() {
            const filterValue = $(this).val();
            const rows = $('.page-row');

            rows.each(function() {
                const activeAttr = $(this).data('active');
                const isActive = activeAttr === true || activeAttr === 'true';
                
                switch(filterValue) {
                    case 'active':
                        $(this).toggle(isActive);
                        break;
                    case 'inactive':
                        $(this).toggle(!isActive);
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
</x-admin-layout>