<aside class="w-72 bg-white h-screen shadow-sm fixed flex flex-col justify-between border-r border-gray-200">
    <!-- Logo Section -->
    <div class="flex flex-col h-full">
        <div class="p-6 flex items-center space-x-2 border-b border-gray-200">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ Vite::asset('resources/images/freshcart-logo.svg') }}" class="h-8 w-auto transition-transform duration-200 hover:scale-105" alt="Logo">
            </a>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 mt-4 px-4 overflow-y-auto">
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <x-admin.nav-link href="/admin/dashboard" :active="request()->is('admin/dashboard')" 
                        class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                        <i class="mdi mdi-view-dashboard text-xl mr-3"></i> 
                        <span class="font-medium">Dashboard</span>
                    </x-admin.nav-link>
                </li>

                <!-- Store Management Section -->
                <li class="pt-4">
                    {{-- <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Store Management</p> --}}
                    <ul class="space-y-1">
                        @can('manage_products')
                        <li>
                            <x-admin.nav-link href="/admin/products" :active="request()->is('admin/products*')"
                                class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-shopping text-xl mr-3"></i>
                                <span class="font-medium">Products</span>
                            </x-admin.nav-link>                               
                        </li>
                        @endcan
                        
                        @can('manage_categories')  
                        <li>
                            <x-admin.nav-link href="/admin/categories" :active="request()->is('admin/categories*')"
                                class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-shape text-xl mr-3"></i>
                                <span class="font-medium">Categories</span>
                            </x-admin.nav-link>
                        </li>
                        @endcan
                        
                        @can('manage_orders')
                        <li>
                            <x-admin.nav-link href="/admin/orders" :active="request()->is('admin/orders*')"
                                class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-cart text-xl mr-3"></i>
                                <span class="font-medium">Orders</span>
                            </x-admin.nav-link>
                        </li>
                        @endcan
                        
                        @can('manage_customers')
                        <li>
                            <x-admin.nav-link href="/admin/customers" :active="request()->is('admin/customers*')"
                                class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-account-group text-xl mr-3"></i>
                                <span class="font-medium">Customers</span>
                            </x-admin.nav-link>
                        </li>
                        @endcan
                    </ul>
                </li>

                <!-- System Section -->
                <li class="pt-4">
                    {{-- <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">System</p> --}}
                    <ul class="space-y-1">
                        @can('manage_admins')
                        <li>
                            <x-admin.nav-link href="/admin/admins" :active="request()->is('admin/admins*')"
                                class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-account-multiple text-xl mr-3"></i>
                                <span class="font-medium">Admins</span>
                            </x-admin.nav-link>
                        </li>
                        @endcan
                        
                        @can('manage_roles')
                        <li>
                            <x-admin.nav-link href="/admin/roles" :active="request()->is('admin/roles*')"
                                class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="material-icons text-xl mr-3">verified_user</i>
                                <span class="font-medium">Roles</span>
                            </x-admin.nav-link>
                        </li>
                        @endcan
                        
                        @can('manage_permissions')
                        <li>
                            <x-admin.nav-link href="/admin/permissions" :active="request()->is('admin/permissions*')"
                                class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="material-icons text-xl mr-3">shield</i>
                                <span class="font-medium">Permissions</span>
                            </x-admin.nav-link>
                        </li>
                        @endcan
                        
                        @can('manage_static_blocks')
                        <li>
                            <x-admin.nav-link href="/admin/static-blocks" :active="request()->is('admin/static-blocks*')"
                                class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-file-document-edit text-xl mr-3"></i>
                                <span class="font-medium">Static Blocks</span>
                            </x-admin.nav-link>
                        </li>
                        @endcan
                        
                        @can('manage_static_pages')
                        <li>
                            <x-admin.nav-link href="/admin/static-pages" :active="request()->is('admin/static-pages*')"
                                class="flex items-center px-4 py-2.5 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-file-document text-xl mr-3"></i>
                                <span class="font-medium">Static Pages</span>
                            </x-admin.nav-link>
                        </li>
                        @endcan
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Bottom Section -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center mb-3">
            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                <i class="mdi mdi-account text-xl text-green-600"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Admin User' }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->role->roles ?? 'Admin' }}</p>
            </div>
        </div>
        <form action="/admin/logout" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 font-medium text-sm shadow-sm hover:shadow-md">
                <i class="mdi mdi-logout text-lg mr-2"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>