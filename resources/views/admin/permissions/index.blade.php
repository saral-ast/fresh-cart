<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="material-icons mr-2 text-gray-600">shield</span>
                Permissions Management
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.permissions.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-all shadow-sm">
                    <span class="material-icons mr-2 text-sm">add</span>
                    Add Permission
                </a>
            </div>
        </div>
        
        <!-- Permissions Table -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm">
                            <th class="px-6 py-4 text-left font-semibold">ID</th>
                            <th class="px-6 py-4 text-left font-semibold">Permission Name</th>
                            <th class="px-6 py-4 text-left font-semibold">Created At</th>
                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($permissions as $permission)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">{{ $permission->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $permission->permission }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-500">{{ $permission->created_at ? $permission->created_at->format('d M Y h:i A') : '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors flex items-center">
                                            <span class="material-icons text-sm mr-1">edit</span>
                                            Edit
                                        </a>
                                        <button type="button" 
                                               class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors flex items-center"
                                               onclick="openDeleteModal({{ $permission->id }}, '{{ $permission->permission }}')">
                                            <span class="material-icons text-sm mr-1">delete</span>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($permissions->isEmpty())
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center gap-1">
                                        <span class="material-icons text-3xl">shield</span>
                                        <p>No permissions found</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $permissions->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900/70 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <span class="material-icons text-red-500 mr-2">warning</span>
                    Delete Permission
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700">Are you sure you want to delete the permission <span id="permissionNameToDelete" class="font-semibold"></span>?</p>
                <p class="text-gray-600 text-sm mt-2">This action cannot be undone.</p>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                <button type="button" 
                        class="border border-gray-300 bg-white text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors"
                        onclick="closeDeleteModal()">
                    Cancel
                </button>
                <form id="deleteForm" action="" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        Delete Permission
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(permissionId, permissionName) {
            document.getElementById('deleteForm').action = "{{ route('admin.permissions.destroy', '') }}/" + permissionId;
            document.getElementById('permissionNameToDelete').textContent = permissionName;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when clicking outside of it
        document.getElementById('deleteModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
                closeDeleteModal();
            }
        });
    </script>
</x-admin-layout>