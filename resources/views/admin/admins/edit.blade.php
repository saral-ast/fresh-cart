<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="material-icons mr-2 text-gray-600">admin_panel_settings</span>
                Edit Admin
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.admins.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg font-medium flex items-center justify-center transition-all">
                    <span class="material-icons mr-2 text-sm">arrow_back</span>
                    Back to Admins
                </a>
            </div>
        </div>
        
        <!-- Admin Form -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6 md:p-8">
            <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}" 
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition-all"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" 
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition-all"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (leave empty to keep current)</label>
                        <input type="password" name="password" id="password" 
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition-all">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Role -->
                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role_id" id="role_id" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition-all"
                                required>
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $admin->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->roles }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium transition-all shadow-sm">
                        Update Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>