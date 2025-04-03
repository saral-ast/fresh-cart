<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="material-icons mr-2 text-gray-600">verified_user</span>
                Add New Role
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.roles.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-all">
                    <span class="material-icons mr-2 text-sm">arrow_back</span>
                    Back to Roles
                </a>
            </div>
        </div>
        
        <!-- Role Form -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6 md:p-8">
            <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Role Name -->
                    <div>
                        <label for="roles" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                        <input type="text" name="roles" id="roles" value="{{ old('roles') }}" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="Enter role name" required>
                        @error('roles')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Permissions -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Permissions</label>
                        
                        @error('permissions')
                            <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($permissions as $permission)
                                <div class="flex items-center">
                                    <input type="checkbox" name="permissions[]" id="permission-{{ $permission->id }}" value="{{ $permission->id }}" 
                                           class="rounded border-gray-300 text-green-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-700">{{ $permission->permission }}</label>
                                </div>
                            @endforeach
                            
                            @if($permissions->isEmpty())
                                <div class="col-span-full">
                                    <p class="text-gray-500 italic">No permissions available. <a href="{{ route('admin.permissions.create') }}" class="text-green-600 hover:underline">Create some permissions</a> first.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium shadow-sm transition-colors">
                        Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>