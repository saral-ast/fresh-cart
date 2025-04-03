<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="material-icons mr-2 text-gray-600">shield</span>
                Edit Permission
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.permissions.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-all">
                    <span class="material-icons mr-2 text-sm">arrow_back</span>
                    Back to Permissions
                </a>
            </div>
        </div>
        
        <!-- Permission Form -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6 md:p-8">
            <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Permission Name -->
                    <div>
                        <label for="permission" class="block text-sm font-medium text-gray-700 mb-1">Permission Name</label>
                        <input type="text" name="permission" id="permission" value="{{ old('permission', $permission->permission) }}" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="Enter permission name" required>
                        @error('permission')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium shadow-sm transition-colors">
                        Update Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>