<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="material-icons mr-2 text-gray-600">admin_panel_settings</span>
                Admins Management
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.admins.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-all shadow-sm">
                    <span class="material-icons mr-2 text-sm">add</span>
                    Add Admin
                </a>
            </div>
        </div>
        
        <!-- Admins Table -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm">
                            <th class="px-6 py-4 text-left font-semibold">Name</th>
                            <th class="px-6 py-4 text-left font-semibold">Email</th>
                            <th class="px-6 py-4 text-left font-semibold">Role</th>
                            <th class="px-6 py-4 text-left font-semibold">Permissions</th>
                            <th class="px-6 py-4 text-left font-semibold">Created At</th>
                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($admins as $admin)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $admin->name }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $admin->email }}</td>
                                <td class="px-6 py-4">
                                    @if($admin->role)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <span class="material-icons text-xs mr-1">verified</span>
                                            {{ $admin->role->roles }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($admin->role && $admin->role->permissions->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($admin->role->permissions as $permission)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <span class="material-icons text-xs mr-1">check_circle</span>
                                                    {{ $permission->permission }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400">No permissions</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-500">{{ $admin->created_at ? $admin->created_at->format('d M Y h:i A') : '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                    @if($admin->id !== auth()->guard('admin')->id()) 
                                        <a href="{{ route('admin.admins.edit', $admin->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors flex items-center">
                                            <span class="material-icons text-sm mr-1">edit</span>
                                            Edit
                                        </a>
                                    
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors flex items-center"
                                                    onclick="openDeleteModal('{{ $admin->id }}', '{{ $admin->name }}')">
                                                <span class="material-icons text-sm mr-1">delete</span>
                                                Delete
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($admins->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center gap-1">
                                        <span class="material-icons text-3xl">person_off</span>
                                        <p>No admins found</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal for Admin -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900/70 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <span class="material-icons text-red-500 mr-2">warning</span>
                    Delete Admin
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700">
                    Are you sure you want to delete admin <span id="adminNameToDelete" class="font-semibold"></span>?
                </p>
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
                        Delete Admin
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(adminId, adminName) {
            document.getElementById('deleteForm').action = "{{ route('admin.admins.destroy', '') }}/" + adminId;
            document.getElementById('adminNameToDelete').textContent = adminName;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        document.getElementById('deleteModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
                closeDeleteModal();
            }
        });
    </script>
</x-admin-layout>
